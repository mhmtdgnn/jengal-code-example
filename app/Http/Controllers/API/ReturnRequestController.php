<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestDetail;
use App\Models\Product;
use App\Models\Consumer;
use Validator;
use Str;

class ReturnRequestController extends Controller
{
    public function telclear($gsm)
    {
        $metin  = $gsm;
        $eski   = array('(',')','-',' ');
        $yeni   = array('','','','');
        $metin = str_replace($eski, $yeni, $metin);
        return $metin;
    }

    /**
     * Create method.
     *
     * @return \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        //dd($request->return);
        $customer = $request->return['customer'];
        $product = $request->return['product'];

        $exists = Consumer::where('email', $customer['email'])->exists();
        if ($exists) {
            $consumer = Consumer::where('email', $customer['email'])->first();
        } else {
            $consumer = new Consumer();
            $consumer->guid = Str::uuid();
            $consumer->firstName = $customer['firstname'];
            $consumer->lastName = $customer['lastname'];
            $consumer->phone = $this->telclear($customer['phone']);
            $consumer->email = $customer['email'];
            $consumer->save();
        }

        $return = new ReturnRequest();
        $return->user_id     = 9999;
        $return->consumer_id = $consumer->id;
        $return->magaza_id   = 9999;
        $return->status      = 2;
        $return->tip         = $customer['statusId'];
        $return->adet        = array_sum(array_column($product, 'quantity'));
        $return->kalem       = 0;
        $return->koli        = 0;
        $return->refundOrderNumber = $customer['orderId'];
        $return->save();

        foreach ($product as $item) {
            $findProduct = Product::where('product_code', $item['model'])->first();

            for ($i=0; $i < $item['quantity']; $i++) {
                $detail = new ReturnRequestDetail();
                $detail->talep_id = $return->id;
                $detail->product_id = $findProduct->id;
                $detail->product_sap_code = $findProduct->product_sap_code;
                $detail->product_code = $findProduct->product_code;
                $detail->sebep = $customer['returnReason'];
                $detail->not = $customer['returnNote'];
                $detail->isOk = 0;
                $detail->guid = Str::uuid();
                $detail->barkod = $return->id.'-'.random_int(100000, 999999);
                $detail->save();
            }
        }
        return response()->json(
            [
                "status" => true,
                "message" => "İade talebi oluşturuldu.",
                "data" => $return
            ]
        );
    }
}
