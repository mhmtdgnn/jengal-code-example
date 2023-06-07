<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Message;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SimpleXMLElement;

class SmsController extends Controller
{
    public function index()
    {
        $title = "SMS Yönetimi";
        $messages = Message::orderBy('id', 'DESC')->paginate(30);

        return view('cm.sms-management', compact('messages'));
    }

    public function sendSMS(Request $request)
    {
        $phone = preg_replace('/\D+/', '', $request->tocustomer);

        $sms = new Message();
        $sms->from = Auth::user()->id;
        $sms->to = $phone;
        $sms->message = $request->message;

        $curl_new = curl_init();
        curl_setopt_array(
            $curl_new, array(
                CURLOPT_URL => 'https://api.iletimerkezi.com/v1/send-sms/json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => "{\n   \"request\":{\n      \"authentication\":{\n        
                        \"key\":\"43a73eef83b0711faa415c0601bff813\",\n      
                        \"hash\":\"603ac17d039ceccdac694d72fb78ce110d5fedc19daf17265b3fb8b363a05c8e\"\n      },\n   
                            \"order\":{\n         \"sender\":\"BiCozum\",\n         \"sendDateTime\":[\n\n         ],\n       
                                \"message\":{\n            \"text\":\"". $request->message ." \",\n           
                                    \"receipents\":{\n               \"number\":[\n                 
                                        \"$phone\"\n               ]\n            
                                    }\n         }\n      }\n   }\n}",
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Cookie: emsid=pgq73a8fsjdn5g5sor1k8o0ac6'
                ),
            )
        );

        $response_new = curl_exec($curl_new);
        curl_close($curl_new);
        $response_new = json_decode($response_new);
        
        if ($response_new->response->status->code == 200) {
            $sms->save();
            return back()->with('msg', 'SMS başarıyla gönderilmiştir.');
        } else {
            return back()->with('msg', 'Sistemde hata meydana geldi. Lütfen yazılım ekibi ile görüşün.');
        }
    } 
}
