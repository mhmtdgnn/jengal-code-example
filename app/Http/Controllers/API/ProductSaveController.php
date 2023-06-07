<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YenileProduct;
use App\Models\Product;
use App\Models\Consumer;
use App\Models\SavedProduct;
use App\Models\SavedProductDocument;
use Illuminate\Support\Facades\Storage;
use Validator;
use Str;

class ProductSaveController extends Controller
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
     * consumer.
     *
     * @return \Illuminate\Http\Request
     */
    public function consumer(Request $request)
    {
        $validateCustomer = Validator::make(
            $request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric|digits:10'
            ]
        );

        if ($validateCustomer->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateCustomer->errors()
                ], 401
            );
        }

        $exists = Consumer::where('phone', $request->phone)->where('company_id', 9)->exists();
        if ($exists) {
            $consumer = Consumer::where('phone', $request->phone)->where('company_id', 9)->first();
        } else {
            $consumer = new Consumer();
            $consumer->company_id = 9;
            $consumer->guid = Str::uuid();
            $consumer->firstName = $request->firstName;
            $consumer->lastName = $request->lastName;
            $consumer->phone = $this->telclear($request->phone);
            $consumer->email = $request->email;
            $consumer->save();
        }

        return $consumer->id;
    }
    /**
     * Search method.
     *
     * @return \Illuminate\Http\Request
     */
    public function search(Request $request)
    {
        return YenileProduct::select('id', 'product_code', 'product_name')
            ->where('product_name', 'LIKE', '%'.$request->product.'%')
            ->orWhere('product_code', 'LIKE', '%'.$request->product.'%')
            ->get();
    }
    /**
     * Create method.
     *
     * @return \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        //dd($request->return);

        $savedProduct = new SavedProduct();
        $savedProduct->consumer_id    = $request->consumer;
        $savedProduct->product_id     = $request->product;
        $savedProduct->invoice_date    = $request->invoiceDate;
        $savedProduct->warranty_code   = $request->warrantyCode;
        $savedProduct->serial_number   = $request->serialNumber;
        $savedProduct->campaign_code   = $request->campaignCode;
        $savedProduct->save();

        if (isset($request->productImage)) {
            $productDocument = new SavedProductDocument();
            $productDocument->saved_product_id = $savedProduct->id;

            $image = $request->productImage;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10).'.'.'png';
            $productDocument->file_url = $imageName;
            $productDocument->type = 'product';

            $productDocument->save();

            Storage::disk('ftp')->put('saved_product_documents/'.$savedProduct->id.'/'.date("Y-m-d").'/'.$imageName, base64_decode($image));
        }

        if (isset($request->billImage)) {
            $billDocument = new SavedProductDocument();
            $billDocument->saved_product_id = $savedProduct->id;

            $image = $request->productImage;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10).'.'.'png';
            $billDocument->file_url = $imageName;
            $billDocument->type = 'bill';

            $billDocument->save();

            Storage::disk('ftp')->put('saved_product_documents/'.$savedProduct->id.'/'.date("Y-m-d").'/'.$imageName, base64_decode($image));
        }


        return response()->json(
            [
                "status" => true,
                "message" => "Ürün kaydetme işlemi başarıyla oluşturuldu.",
                "data" => $savedProduct
            ]
        );
    }
}
