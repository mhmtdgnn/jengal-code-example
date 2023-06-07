<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PickupRequest;
use App\Models\PickupRequestDetail;
use App\Models\PickupRequestLog;
use App\Models\Consumer;
use App\Models\Product;
use Validator;
use Str;
use Illuminate\Support\Facades\Auth;

class PickupRequestController extends Controller
{
    public function telclear($gsm)
    {
        $metin  = $gsm;
        $eski   = array('(',')','-',' ');
        $yeni   = array('','','','');
        $metin = str_replace($eski, $yeni, $metin);
        return $metin;
    }

    public function show()
    {
        $pickups = PickupRequest::select('pickup_requests.*', 'prs.status_name', 'prs.status_color', 'company.logo_url')
            ->with('service')
            ->leftJoin('pickup_request_statuses AS prs', 'prs.status_code', '=', 'pickup_requests.status')
            ->leftJoin('users AS user', 'user.id', '=', 'pickup_requests.user_id')
            ->leftJoin('companies AS company', 'company.id', '=', 'user.company_id')
            ->orderBy('pickup_requests.created_at', 'DESC')
            ->get();

        return $pickups;
    }

    /**
     * Create method.
     *
     * @return \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $validateCustomer = Validator::make(
            $request->customer, [
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
        
        $customer = $request->customer;
        $details = $request->details;

        $exists = Consumer::where('email', $customer['email'])->exists();
        if ($exists) {
            $consumer = Consumer::where('email', $customer['email'])->first();
        } else {
            $consumer = new Consumer();
            $consumer->guid = Str::uuid();
            $consumer->firstName = $customer['firstName'];
            $consumer->lastName = $customer['lastName'];
            $consumer->phone = $this->telclear($customer['phone']);
            $consumer->email = $customer['email'];
            $consumer->save();
        }
        
        $pickUpRequest = new PickupRequest();
        $pickUpRequest->user_id         = 99999;
        $pickUpRequest->store_id        = 0;
        $pickUpRequest->consumer_id     = $consumer->id;
        $pickUpRequest->type            = $request->request_type;
        $pickUpRequest->status          = 1000;
        $pickUpRequest->piece           = count($details);
        $pickUpRequest->note            = $request->order_note;
        $pickUpRequest->address         = $request->address;
        $pickUpRequest->invoice_amount  = count($details) * 0;
        $pickUpRequest->whopays         = $request->whopays;
        $pickUpRequest->paying_type     = ($request->whopays == 'firma_oder') ? '' : $request->payment_type;
        $pickUpRequest->spare_product   = (isset($request->spare_product)) ? $request->spare_product : 0;
        $pickUpRequest->save();

        foreach ($details as $item) {
            $product = Product::where('product_code', $item['productCode'])->first();

            $detail = new PickupRequestDetail();
            $detail->pickup_request_id = $pickUpRequest->id;
            $detail->product_id        = $product->id;
            $detail->description       = $item['complaint'];
            $detail->has_warranty      = $item['has_warranty'];
            $detail->save();
        }

        return response()->json(
            [
                "status" => true,
                "message" => "Evden alım talebi oluşturuldu.",
                "data" => $return
            ]
        );
    }
}
