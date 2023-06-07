<?php

namespace App\Jobs;

use App\Models\Consumer;
use App\Models\VorwerkOrder;
use App\Models\VorwerkOrderDetail;
use App\Models\VorwerkOrderLog;
use App\Models\Product;
use App\Models\UPSDistrict;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Str;

class ThermomixOrderManagement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function telclear($gsm)
    {
        $metin  = $gsm;
        $eski   = array('(',')','-',' ');
        $yeni   = array('','','','');
        $metin = str_replace($eski, $yeni, $metin);
        return $metin;
    }

    public function searchForProduct($value, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['inventory_item_number'] == $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->data['order'];
        $i = $this->data['i'];
        $giftItem = $this->data['giftItem'];
        $transferMethod = '';
        
        if (VorwerkOrder::where('siparis_kodu', trim($order[$i]['customer_order_number']))->doesntExist()) {
            $exists = Consumer::where('phone', 'LIKE', '%'.$this->telclear($order[$i]['destination_phoneone']).'%')->exists();

            if ($exists) {
                $consumer = Consumer::where('phone', 'LIKE', '%'.$this->telclear($order[$i]['destination_phoneone']).'%')->first();
            } else {
                $consumer = new Consumer();
                $consumer->guid = Str::uuid();
                $consumer->firstName = mb_strtoupper($order[$i]['destination_contact_first_name']);
                $consumer->lastName = mb_strtoupper($order[$i]['destination_contact_last_name']);
                $consumer->phone = $this->telclear($order[$i]['destination_phoneone']);
                $consumer->save();
            }

            if (!empty($order[$i]['advisor']) and ($order[$i]['advisor'] != 'thermomixturkiye@vorwerk.com.tr') and ($this->searchForProduct('62217', $order)) and (floatval($order[$i]['total_price_qxprice_for_item']) >= 20990.0)) {
                $giftItem = 1;
            } else {
                $giftItem = 0;
            }

            if ((trim(mb_strtoupper($order[$i]['destination_province'])) == 'İSTANBUL') OR (trim(mb_strtoupper($order[$i]['destination_province'])) == 'ISTANBUL')) {
                $transferMethod = 'BİÇÖZÜM';
            } else {
                $transferMethod = 'UPS';
            }

            $cityCode = UPSDistrict::select('city_id')->where('city_name', $order[$i]['destination_province'])->first();
            $areaCode = UPSDistrict::select('area_id')->where('city_name', $order[$i]['destination_province'])->where('area_name', $order[$i]['destination_city'])->first();

            $vorwerkOrder = new VorwerkOrder();
            $vorwerkOrder->siparis_kodu = $order[$i]['customer_order_number'];
            $vorwerkOrder->siparis_tarihi = $order[$i]['order_datetime'];
            $vorwerkOrder->durum = 1;
            $vorwerkOrder->consumer_id = $consumer->id;
            $vorwerkOrder->transfer_yontemi = $transferMethod;
            $vorwerkOrder->hediye_urun = $giftItem;
            $vorwerkOrder->teslimat_isim = mb_strtoupper($order[$i]['destination_contact_first_name']);
            $vorwerkOrder->teslimat_soyisim = mb_strtoupper($order[$i]['destination_contact_last_name']);
            $vorwerkOrder->teslimat_adresi1 = $order[$i]['destination_streetone'];
            $vorwerkOrder->teslimat_adresi2 = $order[$i]['destination_streettwo'];

            $vorwerkOrder->teslimat_il = $order[$i]['destination_province'];
            $vorwerkOrder->teslimat_il_ups = $cityCode->city_id ?? null;
            $vorwerkOrder->teslimat_ilce = $order[$i]['destination_city'];
            $vorwerkOrder->teslimat_ilce_ups = $areaCode->area_id ?? null;

            $vorwerkOrder->teslimat_tarif = $order[$i]['order_note'];
            $vorwerkOrder->teslimat_posta_kodu = $order[$i]['destination_postal_code'];
            $vorwerkOrder->barcode_printed = 0;
            $vorwerkOrder->save();

            $vorwerkOrderID = $vorwerkOrder->id;

            $orderLog = new VorwerkOrderLog();
            $orderLog->user_id = $this->data['user_id'];;
            $orderLog->order_id = $vorwerkOrderID;
            $orderLog->type_key = 'create';
            $orderLog->description = 'Sipariş Alındı';
            $orderLog->save();

            foreach ($order as $item) {
                $product = Product::where('product_code', $item['inventory_item_number'])->first();

                for ($q=0; $q < intval($item['requested_quantity']); $q++) {
                    $orderDetail =  new VorwerkOrderDetail();
                    $orderDetail->order_id = $vorwerkOrderID;
                    $orderDetail->product_id = @$product->id;
                    $orderDetail->unit_price = $item['total_price_qxprice_for_item'];
                    $orderDetail->save();
                }
            }
        }
    }
}
