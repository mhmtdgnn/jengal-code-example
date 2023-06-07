<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\ConsumerAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConsumerController extends Controller
{
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

    public function getConsumerInfo(Request $request)
    {
        $consumer = Consumer::find($request->consumer_id);
        $return['consumer'] = $consumer;

        return $return;
    }

    /**
     * Ajax - Search Consumer
     *
     * @param Request $request
     * @return void
     */
    public function consumerSearch(Request $request)
    {
        $splitName = $this->splitName($request->consumerName);
        if (!is_null($request->consumerName)) {
            $data = Consumer::where('firstName', 'LIKE', '%'.$splitName[0].'%')
                ->where('lastName', 'LIKE', '%'.$splitName[1].'%')
                ->get();
            
            $error = 'Bulunamadı';

            if (count($data) > 0) {
                return response()->json(
                    [
                        'users' => $data,
                    ]
                );
            } else {
                return $error;
            }
        }

        if (!is_null($request->consumerMobilePhone)) {
            $data = Consumer::where('phone', 'LIKE', '%'.$this->telclear($request->consumerMobilePhone).'%')
                ->get();
            
            $error = 'Bulunamadı';

            if (count($data) > 0) {
                return response()->json(
                    [
                        'users' => $data,
                    ]
                );
            } else {
                return $error;
            }
        }
        
        if (!is_null($request->phone)) {
            $consumers = Consumer::where('phone', preg_replace('/[^0-9]/', '', $request->phone))
                ->where('company_id', Auth::user()->company_id)
                ->get();

            return $consumers;
        }
    }

    public function consumerCheckEmail(Request $request)
    {
        $input = $request->only(['email']);

        $request_data = [
            'email' => 'required|email|unique:consumers,email',
        ];

        $validator = Validator::make($input, $request_data);

        // json is null
        if ($validator->fails()) {
            $errors = json_decode(json_encode($validator->errors()), 1);
            return response()->json(
                [
                    'success' => false,
                    'message' => array_reduce($errors, 'array_merge', array()),
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'The email is available'
                ]
            );
        }
    }

    public function consumerCheck(Request $request)
    {
        $exists = Consumer::where('id', $request->consumer_id)->exists();

        if ($exists) {
            $consumer = Consumer::find($request->consumer_id);

            return $consumer->id;
        } else {
            $consumer = new Consumer();
            $consumer->guid = Str::uuid();
            $consumer->firstName = $request->first_name;
            $consumer->lastName = $request->last_name;
            $consumer->phone = $request->mobile_phone;

            return json_encode($consumer->id);
        }
    }

    /**
     * Ajax - Create Consumer
     *
     * @param Request $request
     * @return void
     */
    public function createConsumer(Request $request)
    {
        try {
            $insert = Consumer::create([
                'guid'      => Str::uuid(),
                'company_id' => Auth::user()->company_id ?? 1,
                'firstName' => strtoupper($request->firstName),
                'lastName'  => strtoupper($request->lastName),
                'phone'     => preg_replace('/\D+/', '', $request->phone),
                'email'     => $request->email
            ]);
        } catch (\Throwable $th) {
            return $th;
        }

        return $insert;
    }

    /**
     * Ajax - Update Consumer
     *
     * @param Request $request
     * @return void
     */
    public function updateConsumer(Request $request)
    {
        try {
            $update = Consumer::where('id', $request->consumerID)
                ->update([
                'firstName' => strtoupper($request->firstName),
                'lastName'  => strtoupper($request->lastName),
                'phone'     => $request->phone,
                'email'     => $request->email
            ]);
        } catch (\Throwable $th) {
            return $th;
        }

        return $update;
    }

    public function createConsumerAddress(Request $request)
    {
        try {
            $address = new ConsumerAddress();
            $address->consumer_id    = $request->consumerID;
            $address->address_name   = $request->address_name;
            $address->address        = $request->address;
            $address->town           = $request->address_town;
            $address->city           = $request->address_city;
            $address->status         = 1;
            $address->save();
        } catch (\Throwable $th) {
            throw $th;
        }

        return $address;
    }

    public function getConsumerAddress(Request $request)
    {
        $addresses = ConsumerAddress::select(
            'consumer_addresses.id AS id', 
            'consumer_addresses.address_name AS address_name', 
            'consumer_addresses.address AS address',
            'c.name AS city',
            't.name AS town')
            ->leftJoin('cities AS c', 'c.id', '=', 'consumer_addresses.city')
            ->leftJoin('towns AS t', 't.id', '=', 'consumer_addresses.town')
            ->where('consumer_id', $request->consumer_id)->get();

        $response['addresses'] = $addresses;
        return $response;
    }

    public function getSelectedAddress(Request $request)
    {
        $address = ConsumerAddress::find($request->addressID);

        return $address;
    }

    public function updateConsumerAddress(Request $request)
    {
        try {
            $update = ConsumerAddress::where('id', $request->addressID)
                ->update(
                    [
                        'address_name'  => $request->address_name,
                        'address'       => $request->address,
                        'city'          => $request->address_city,
                        'town'          => $request->address_town,
                    ]
                );
        } catch (\Throwable $th) {
            throw $th;
        }

        return $update;
    }
}
