<?php

namespace App\Http\Controllers;

use App\Models\ReturnCode;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use SimpleXMLElement;

class CargoController extends Controller
{
    public function index()
    {
        $title = "Kargo Yönetimi";
        $returnCodes = ReturnCode::orderBy('id', 'DESC')->paginate(100);

        return view('cm.cargo-management', compact('returnCodes'));
    }

    public function store(Request $request)
    {
        $phone = preg_replace('/\D+/', '', $request->phone);

        $validate = Validator::make(
            $request->all(), [
                'cargo_company' => 'required',
                'consumer' => 'required|min:5',
                'platform' => 'required',
                'reason' => 'required'
            ],
            [
                'phone' => 'Telefon numarasını eksiksiz ve düzgün bir şekilde giriniz!'
            ]
        );

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        if ($request->cargo_company == 'MNG') {
            $number = rand(1044444, 9944444);
            $mngXML = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
            <soap12:Envelope
                xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
                xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
                xmlns:soap12=\"http://www.w3.org/2003/05/soap-envelope\">\n
                <soap12:Body>\n
                    <GelecekIadeSiparisKayit
                        xmlns=\"http://tempuri.org/\">\n
                        <pKullaniciAdi>345309865</pKullaniciAdi>\n
                        <pSifre>TOEYUFSL</pSifre>\n

                        <pSiparisNo>".$number."</pSiparisNo>\n
                        <pIrsaliyeNo></pIrsaliyeNo>\n
                        <pGonderenMusteri>\n

                            <pGonMusteriMngNo></pGonMusteriMngNo>\n
                            <pGonMusteriBayiNo></pGonMusteriBayiNo>\n
                            <pGonMusteriSiparisNo></pGonMusteriSiparisNo>\n
                            <pGonMusteriAdi></pGonMusteriAdi>\n
                            <pGonMusAdresFarkli>0</pGonMusAdresFarkli>
                            \n
                            <pGonIlAdi>ISTANBUL</pGonIlAdi>\n
                            <pGonilceAdi>KADIKÖY</pGonilceAdi>\n
                            <pGonAdresText></pGonAdresText>\n
                            <pGonSemt></pGonSemt>\n
                            <pGonMahalle></pGonMahalle>\n
                            <pGonMeydanBulvar></pGonMeydanBulvar>\n
                            <pGonCadde></pGonCadde>\n
                            <pGonSokak></pGonSokak>\n
                            <pGonTelIs></pGonTelIs>\n

                            <pGonTelEv></pGonTelEv>\n
                            <pGonTelCep></pGonTelCep>\n
                            <pGonFax></pGonFax>\n
                            <pGonEmail></pGonEmail>\n

                            <pGonVergiDairesi></pGonVergiDairesi>\n
                            <pGonVergiNumarasi></pGonVergiNumarasi>\n

                        </pGonderenMusteri>\n

                        <pOdemeSekli>Gonderici_Odeyecek</pOdemeSekli>\n
                        <pAciklama>string</pAciklama>\n

                    </GelecekIadeSiparisKayit>\n

                </soap12:Body>\n
            </soap12:Envelope>";

            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://service.mngkargo.com.tr/musterikargosiparis/musterisiparisnew.asmx?op=GelecekIadeSiparisKayit',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $mngXML,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic MzU2MTU3MTk6MzU2VFNUMjQyNVhHSFBSRlRH'
                    ),
                )
            );

            $response = curl_exec($curl);
            curl_close($curl);
            $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $response);
            $xml = new SimpleXMLElement($clean_xml);

            if ($xml->Body->GelecekIadeSiparisKayitResponse->GelecekIadeSiparisKayitResult == '1') {
                $curl_new = curl_init();
                curl_setopt_array(
                    $curl_new,
                    array(
                        CURLOPT_URL => 'https://api.iletimerkezi.com/v1/send-sms/json',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => "{\n \"request\":{\n \"authentication\":{\n \"key\":\"43a73eef83b0711faa415c0601bff813\",\n
    \"hash\":\"603ac17d039ceccdac694d72fb78ce110d5fedc19daf17265b3fb8b363a05c8e\"\n },\n \"order\":{\n
    \"sender\":\"BiCozum\",\n \"sendDateTime\":[\n\n ],\n \"message\":{\n \"text\":\"Sayın müşterimiz iade gönderinizi 693265990 cari kodu ve ". $number ." iade onay kodu ile MNG şubelerine teslim edebilirsiniz. Sitemizden sipariş oluşturduğunuz Ad Soyad ve Telefon ile iade işlemini sağlamanız gerekmektedir. Farklı Ad Soyad ile gönderilen iadeler depoda bulunamadığı için iade işlemi sağlanamamaktadır. İyi günler dileriz.\",\n
    \"receipents\":{\n \"number\":[\n \"$phone\"\n ]\n }\n }\n }\n }\n}",
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Cookie: emsid=pgq73a8fsjdn5g5sor1k8o0ac6'
                        ),
                    )
                );
                $response_new = curl_exec($curl_new);
                curl_close($curl_new);
                $response_new = json_decode($response_new);
                if ($response_new->response->status->code == '200') {
                    $code = $number;
                } else {
                    return back()->with('msg', 'Sistemde hata meydana geldi. Lütfen yazılım ekibi ile görüşün.');
                }
            } else {
                $code = '0';
            }

            $returnCode = new ReturnCode();
            $returnCode->code = $code;
            $returnCode->cargo_company = $request->cargo_company;
            $returnCode->consumer = $request->consumer;
            $returnCode->phone = $phone;
            $returnCode->platform = $request->platform;
            $returnCode->reason = $request->reason;
            $returnCode->note = $request->note;
            $returnCode->save();

            return back()->with('msg', 'Kod üretildi ve gönderildi.');
        } else {
            $curl_new = curl_init();
            curl_setopt_array(
                $curl_new,
                array(
                    CURLOPT_URL => 'https://api.iletimerkezi.com/v1/send-sms/json',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => "{\n \"request\":{\n \"authentication\":{\n \"key\":\"43a73eef83b0711faa415c0601bff813\",\n
    \"hash\":\"603ac17d039ceccdac694d72fb78ce110d5fedc19daf17265b3fb8b363a05c8e\"\n },\n \"order\":{\n
    \"sender\":\"BiCozum\",\n \"sendDateTime\":[\n\n ],\n \"message\":{\n \"text\":\"Sayın müşterimiz gönderinizi 72Y72Y
    müşteri kodu ile UPS kargo şubelerinden tarafımıza gönderebilirsiniz. İyi günler dileriz.\",\n \"receipents\":{\n
    \"number\":[\n \"$phone\"\n ]\n }\n }\n }\n }\n}",
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Cookie: emsid=pgq73a8fsjdn5g5sor1k8o0ac6'
                    ),
                )
            );

            $response_new = curl_exec($curl_new);

            curl_close($curl_new);
            $response_new = json_decode($response_new);
            if ($response_new->response->status->code == '200') {
                $returnCode = new ReturnCode();
                $returnCode->code = '72Y72Y';
                $returnCode->cargo_company = $request->cargo_company;
                $returnCode->consumer = $request->consumer;
                $returnCode->phone = $phone;
                $returnCode->platform = $request->platform;
                $returnCode->reason = $request->reason;
                $returnCode->note = $request->note;
                $returnCode->save();

                return back()->with('msg', 'Kod üretildi ve gönderildi.');
            } else {
                return back()->with('msg', 'Sistemde hata meydana geldi. Lütfen yazılım ekibi ile görüşün.');
            }
        }
    }
}
