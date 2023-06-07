<?php

namespace App\Jobs;

use App\Models\Consumer;
use App\Models\ECommerceOrder;
use App\Models\ECommerceOrderDetail;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Str;

class ECommerceOrderManagement implements ShouldQueue
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

    public function splitName($name)
    {
        $parts = explode(" ", trim($name));
        $num = count($parts);
        if ($num > 1) {
            $lastname = array_pop($parts);
        } else {
            $lastname = '';
        }
        $firstname = implode(" ", $parts);
        return array($firstname, $lastname);
    }

    public function createOrder($orderNo, $customerNumber, $customer, $address, $town, $city, $phone, $taxNumber, $detail)
    {
        $orderJson = '{
            "processKey": "80C1AB3A4E920256E053C0A8A7CAA1FF",
            "orderNumber": "'.$orderNo.'",
            "customerNumber": "'.$customerNumber.'",
            "senderTitle": "BİÇÖZÜM",
            "senderAddress": "Şerifali, Bayraktar Blv. No:54/5, 34775 Ümraniye/İstanbul",
            "senderPostCode": "34000",
            "senderArea": "Ümraniye",
            "senderCity": "İstanbul",
            "senderPhoneNumber": "08502555545",
            "recepientTitle": "'.$customer.'",
            "recepientAddress": "'.$address.'",
            "recepientArea": "'.$town.'",
            "recepientCity": "'.$city.'",
            "recepientPhoneNumber": "'.$phone.'",
            "recepientTaxNumber": "'.$taxNumber.'",
            "orderDetail": ['.$detail.']
        }';

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://b2b.horoz.com.tr:7800/ecomwarehouseservice_test/v1/createOrder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $orderJson,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept-Encoding: UTF-8'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        
        return json_decode($response);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();
        $order = $this->data['order'];
        $prods = [];

        if ($this->data['method'] == 'synchronize') {
            foreach ($order->detail as $item) {
                $prods[] = '{
                    "productCode": "'.@$item->prod->product_code.'",
                    "quantity": 1
                }';
            }
            $detail = implode(',', $prods);

            $createOrder = $this->createOrder($order->siparis_no, $order->musteri_kodu, $order->musteri, $order->adres, $order->ilce, $order->il, $order->tel, $order->vergi_numarasi, $detail);

            if ($createOrder->result == 0) {
                ECommerceOrder::where('id', $order->id)->update(['durum' => 2]);
            }
        } else {
            $i = $this->data['i'];
            if (ECommerceOrder::where('siparis_no', trim($order[$i]['siparis_no']))->doesntExist()) {
                $exists = Consumer::where('phone', 'LIKE', '%'.$this->telclear($order[$i]['tel']).'%')->exists();

                if ($exists) {
                    $consumer = Consumer::where('phone', 'LIKE', '%'.$this->telclear($order[$i]['tel']).'%')->first();
                } else {
                    $splitName = $this->splitName($order[$i]['musteri']);

                    $consumer = new Consumer();
                    $consumer->guid = Str::uuid();
                    $consumer->firstName = mb_strtoupper($splitName[0]);
                    $consumer->lastName = mb_strtoupper($splitName[1]);
                    $consumer->phone = $this->telclear($order[$i]['tel']);
                    $consumer->save();
                }

                $ecommerceOrder = new ECommerceOrder();
                $ecommerceOrder->durum = 1;
                $ecommerceOrder->siparis_no = $order[$i]['siparis_no'];
                $ecommerceOrder->musteri_kodu = $order[$i]['musteri_kodu'];
                $ecommerceOrder->musteri = $order[$i]['musteri'];
                $ecommerceOrder->consumer_id = $consumer->id;
                $ecommerceOrder->tel = $order[$i]['tel'];
                $ecommerceOrder->il = mb_strtoupper($order[$i]['il']);
                $ecommerceOrder->ilce = mb_strtoupper($order[$i]['ilce']);
                $ecommerceOrder->adres = $order[$i]['adres'];
                $ecommerceOrder->vergi_dairesi = $order[$i]['vergi_dairesi'];
                $ecommerceOrder->vergi_numarasi = $order[$i]['vergi_numarasi'];
                $ecommerceOrder->ettn_numarasi = $order[$i]['ettn_numarasi'];
                $ecommerceOrder->irsaliye_numarasi = $order[$i]['irsaliye_numarasi'];
                $ecommerceOrder->odeme_bilgisi = $order[$i]['odeme_bilgisi'];
                $ecommerceOrder->kargo_platform_kodu = $order[$i]['kargo_platform_kodu'];
                $ecommerceOrder->platform = $order[$i]['platform'];
                $ecommerceOrder->kargo = $order[$i]['kargo'];
                $ecommerceOrder->firma = $order[$i]['firma'];
                $ecommerceOrder->save();

                $ecommerceOrderID = $ecommerceOrder->id;

                foreach ($order as $item) {
                    $product = Product::where('product_code', $item['urun_kodu'])->first();

                    for ($q=0; $q < intval($item['adet']); $q++) {
                        $orderDetail =  new ECommerceOrderDetail();
                        $orderDetail->order_id = $ecommerceOrderID;
                        $orderDetail->product_id = @$product->id;
                        $orderDetail->save();
                    }
                }
            }
        }
    }
}
