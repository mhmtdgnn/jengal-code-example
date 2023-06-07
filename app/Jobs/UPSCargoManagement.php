<?php

namespace App\Jobs;

use App\Models\VorwerkOrder;
use App\Models\VorwerkOrderCargoCode;
use App\Models\VorwerkOrderLog;
use App\Models\UPSCargoPrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SimpleXMLElement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UPSCargoManagement implements ShouldQueue
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

    public function upsLogin()
    {
        $loginXML = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <Login_Type1 xmlns="https://ws.ups.com.tr/wsCreateShipment">
                    <CustomerNumber>72Y72Y</CustomerNumber>
                    <UserName>0Nr3WDE2AE4Aj65YubsC</UserName>
                    <Password>ZGG8Z2Yk9jTrrG6E1n3H</Password>
                </Login_Type1>
            </soap:Body>
        </soap:Envelope>
        ';

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://ws.ups.com.tr/wsCreateShipment/wsCreateShipment.asmx?op=Login_Type1',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $loginXML,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml'
                ),
                CURLOPT_SSLVERSION => 6,
                CURLOPT_SSL_VERIFYPEER => 0
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        $clean_xml = str_ireplace(['soap:envelope:', 'soap:'], '', $response);
        $xml = new SimpleXMLElement($clean_xml);
        return $xml->Body->Login_Type1Response->Login_Type1Result->SessionID;
    }

    public function upsCreateShipment($sessionID, $consumerName, $consumerAddress, $consumerPhone, $cityCode, $areaCode, $postalCode, $orderNumber, $numberOfPackage, $dimension)
    {
        $shipmentXML = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
            <soap12:Body>
                <CreateShipment_Type3 xmlns="https://ws.ups.com.tr/wsCreateShipment">
                    <SessionID>'.$sessionID.'</SessionID>
                    <ShipmentInfo>
                        <ShipperAccountNumber>72Y72Y</ShipperAccountNumber>
                        <ShipperName>BİÇÖZÜM</ShipperName>
                        <ShipperAddress>Şerifali, Bayraktar Blv. No:54/5, 34775 Ümraniye/İstanbul</ShipperAddress>
                        <ShipperCityCode>34</ShipperCityCode>
                        <ShipperAreaCode>464</ShipperAreaCode>
                        <ShipperPhoneNumber>08502555545</ShipperPhoneNumber>
                        <ConsigneeName>'.$consumerName.'</ConsigneeName>
                        <ConsigneeAddress>'.htmlspecialchars($consumerAddress).'</ConsigneeAddress>
                        <ConsigneeCityCode>'.$cityCode.'</ConsigneeCityCode>
                        <ConsigneeAreaCode>'.$areaCode.'</ConsigneeAreaCode>
                        <ConsigneePostalCode>'.$postalCode.'</ConsigneePostalCode>
                        <ConsigneePhoneNumber>'.$consumerPhone.'</ConsigneePhoneNumber>
                        <ServiceLevel>3</ServiceLevel>
                        <PaymentType>2</PaymentType>
                        <PackageType>K</PackageType>
                        <NumberOfPackages>'.$numberOfPackage.'</NumberOfPackages>
                        <CustomerReferance>'.$orderNumber.'</CustomerReferance>
                        <PackageDimensions>'.$dimension.'</PackageDimensions>
                    </ShipmentInfo>
                    <ReturnLabelLink>true</ReturnLabelLink>
                    <ReturnLabelImage>true</ReturnLabelImage>
                </CreateShipment_Type3>
            </soap12:Body>
        </soap12:Envelope>
        ';
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://ws.ups.com.tr/wsCreateShipment/wsCreateShipment.asmx?op=CreateShipment_Type3',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $shipmentXML,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/soap+xml'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $clean_xml = str_ireplace(['soap:envelope:', 'soap:'], '', $response);
        $xml = new SimpleXMLElement($clean_xml);
        return $xml->Body->CreateShipment_Type3Response->CreateShipment_Type3Result;
    }

    public function upsPackageInfo($sessionID, $cargoCode)
    {
        $infoXML = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <GetTransactionsByTrackingNumber_V1 xmlns="https://ws.ups.com.tr/wsPaketIslemSorgulamaEng/">
              <SessionID>'.$sessionID.'</SessionID>
              <InformationLevel>1</InformationLevel>
              <TrackingNumber>'.$cargoCode.'</TrackingNumber>
            </GetTransactionsByTrackingNumber_V1>
          </soap12:Body>
        </soap12:Envelope>
        ';

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://ws.ups.com.tr/QueryPackageInfo/wsQueryPackagesInfo.asmx?op=GetTransactionsByTrackingNumber_V1',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $infoXML,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/soap+xml'
                ),
                CURLOPT_SSLVERSION => 6,
                CURLOPT_SSL_VERIFYPEER => 0
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $clean_xml = str_ireplace(['soap:envelope:', 'soap:'], '', $response);
        $xml = new SimpleXMLElement($clean_xml);
        return $xml->Body->GetTransactionsByTrackingNumber_V1Response->GetTransactionsByTrackingNumber_V1Result;
    }

    public function upsgetFreight($sessionID, $cargoCode)
    {
        $infoXML = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <GetPackageInfoByTrackingNumber_V1 xmlns="https://ws.ups.com.tr/wsPaketIslemSorgulamaEng/">
              <SessionID>'.$sessionID.'</SessionID>
              <InformationLevel>1</InformationLevel>
              <TrackingNumber>'.$cargoCode.'</TrackingNumber>
            </GetPackageInfoByTrackingNumber_V1>
          </soap12:Body>
        </soap12:Envelope>
        ';

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://ws.ups.com.tr/QueryPackageInfo/wsQueryPackagesInfo.asmx?op=GetPackageInfoByTrackingNumber_V1',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $infoXML,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/soap+xml'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $clean_xml = str_ireplace(['soap:envelope:', 'soap:'], '', $response);
        $xml = new SimpleXMLElement($clean_xml);
        return $xml->Body->GetPackageInfoByTrackingNumber_V1Response->GetPackageInfoByTrackingNumber_V1Result->PackageInformation;
    }

    public function cargoBarcodeImageUpload($order, $cargoNo, $barcodes)
    {
        if ($barcodes) {
            try {
                foreach ($barcodes as $item) {
                    $i = 0;
                    foreach ($item as $row) {
                        $image_base64 = base64_decode($row);

                        $filename = date("YmdHis") . '_' . $cargoNo . '_' . $i .'.png';
                        $filenametostore = 'upsCargoBarcode/' . date("Y-m-d") . '/' .  $filename;

                        $cargoCode = new VorwerkOrderCargoCode();
                        $cargoCode->order_id = $order;
                        $cargoCode->gonderi_barkod_link = $filenametostore;
                        $cargoCode->save();

                        if ($cargoCode) {
                            $upload = Storage::disk('ftp')->put($filenametostore, $image_base64);
                        }
                        $i++;
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                return 'Something went wrong. Error: '.$th;
            }
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();
        $session = $this->upsLogin();

        if ($this->data['method'] == 'single-create') {
            $dimension = '';
            $prods = [];
            $barcodes = [];
            $user = $this->data['user_id'];
            $order = $this->data['order'];
            $numberOfPackage = $this->data['numberOfPackage'];

            foreach ($order->detail as $row) {
                $prods[] = @$row->prod->product_code;
            }
            $products = implode(', ', $prods);

            for ($i=0; $i < $numberOfPackage; $i++) {
                $dimension .= '<DimensionInfo>
                    <DescriptionOfGoods>'.$products.'</DescriptionOfGoods>
                    <Weight>1</Weight>
                </DimensionInfo>';
            }
            if (!empty($order->teslimat_isim) OR !empty($order->teslimat_soyisim)) {
                $consumerName = mb_strtoupper($order->teslimat_isim).' '.mb_strtoupper($order->teslimat_soyisim);
            } else {
                $consumerName = mb_strtoupper($order->consumer->firstName).' '.mb_strtoupper($order->consumer->lastName);
            }
            $consumerAddress = $order->teslimat_adresi1.' '.$order->teslimat_adresi2;

            $upsCodeCreate = $this->upsCreateShipment($session, $consumerName, $consumerAddress, $order->consumer->phone, $order->teslimat_il_ups, $order->teslimat_ilce_ups, $order->teslimat_posta_kodu, $order->siparis_kodu, $numberOfPackage, $dimension);

            if (!empty($upsCodeCreate->ShipmentNo)) {
                VorwerkOrder::where('id', $order->id)->update(['durum' => 2, 'gonderi_takip_no' => $upsCodeCreate->ShipmentNo]);
                $barcodes[] = $upsCodeCreate->BarkodArrayPng->string;
                $this->cargoBarcodeImageUpload($order->id, $upsCodeCreate->ShipmentNo, $barcodes);

                $orderLog = new VorwerkOrderLog();
                $orderLog->user_id = $user;
                $orderLog->order_id = $order->id;
                $orderLog->type_key = 'order_uptade';
                $orderLog->description = 'Sipariş kargoya verilmiştir. Kargo Kodu: '.$upsCodeCreate->ShipmentNo;
                $orderLog->save();
            }
        }

        if ($this->data['method'] == 'bulk-create') {
            $dimension = '';
            $prods = [];
            $barcodes = [];
            $user = $this->data['user_id'];
            $order = $this->data['order'];
            $numberOfPackage = $this->data['numberOfPackage'];

            foreach ($order['detail'] as $row) {
                $prods[] = @$row['product_code'];
            }
            $products = implode(', ', $prods);

            for ($i=0; $i < $numberOfPackage; $i++) {
                $dimension .= '<DimensionInfo>
                        <DescriptionOfGoods>'.$products.'</DescriptionOfGoods>
                        <Weight>1</Weight>
                    </DimensionInfo>';
            }

            if (!empty($order['teslimat_isim']) OR !empty($order['teslimat_soyisim'])) {
                $consumerName = mb_strtoupper($order['teslimat_isim']).' '.mb_strtoupper($order['teslimat_soyisim']);
            } else {
                $consumerName = mb_strtoupper($order['consumer']['firstName']).' '.mb_strtoupper($order['consumer']['lastName']);
            }

            $consumerAddress = $order['teslimat_adresi1'].' '.$order['teslimat_adresi2'];

            $upsCodeCreate = $this->upsCreateShipment($session, $consumerName, $consumerAddress, $order['consumer']['phone'], $order['teslimat_il_ups'], $order['teslimat_ilce_ups'], $order['teslimat_posta_kodu'], $order['siparis_kodu'], $numberOfPackage, $dimension);

            if (!empty($upsCodeCreate->ShipmentNo)) {
                VorwerkOrder::where('id', $order['id'])->update(['durum' => 2, 'gonderi_takip_no' => $upsCodeCreate->ShipmentNo]);
                $barcodes[] = $upsCodeCreate->BarkodArrayPng->string;
                $this->cargoBarcodeImageUpload($order['id'], $upsCodeCreate->ShipmentNo, $barcodes);

                $orderLog = new VorwerkOrderLog();
                $orderLog->user_id = $user;
                $orderLog->order_id = $order['id'];
                $orderLog->type_key = 'order_uptade';
                $orderLog->description = 'Sipariş kargoya verilmiştir. Kargo Kodu: '.$upsCodeCreate->ShipmentNo;
                $orderLog->save();
            }
        }

        if ($this->data['method'] == 'synchronize-transaction') {
            $user = $this->data['user_id'];
            $order = $this->data['order'];
            $upsPackageInfo = $this->upsPackageInfo($session, $order->gonderi_takip_no);
            $check = null;

            $cargoMessage = 'Değerli müşterimiz, "'.$order->siparis_kodu.'" nolu sipairişiniz kargoya verilmiştir. Siparişinizin kargo takibini aşağıdaki linkten gerçekleştirebilirsiniz. Sağlıklı ve lezzetli günler dileriz. Vorwerk Türkiye, https://portal.bicozum.com/order-tracking/'.$order->siparis_kodu;
            $surveyMessage = 'Thermomix® ailesine hoş geldiniz! Mini anketimize katılarak sizi daha yakından tanımamıza ve hizmet kalitemizi geliştirmemize yardımcı olmanızı rica ederiz.  https://tr.surveymonkey.com/r/V77B9KD';

            if (!empty($upsPackageInfo->PackageTransaction)) {
                foreach ($upsPackageInfo->PackageTransaction as $transaction) {
                    switch ($transaction->StatusCode) {
                    case 31:
                        $description = 'Sipariş kargo şubesi tarafından teslim alındı';
                        $statu = 60;
                        $type_key = 'picked_up';
                        $check = true;
                        break;
                    case 2:
                        $description = 'Sipariş UPS kargo tarafından teslim edilmiştir.';
                        $statu = 90;
                        $type_key = 'delivered';
                        $check = true;
                        break;
                    case 0:
                        $check = false;
                        break;
                    }

                    if ($check) {
                        $logs = VorwerkOrderLog::where('order_id', $order->id)->pluck('type_key')->toArray();
                        $exist_log = in_array($type_key, $logs);

                        if (!$exist_log) {
                            VorwerkOrder::where('id', $order->id)->update(['durum' => $statu]);

                            $orderLog = new VorwerkOrderLog();
                            $orderLog->user_id = $user;
                            $orderLog->order_id = $order->id;
                            $orderLog->type_key = $type_key;
                            $orderLog->description = $description;
                            $orderLog->save();

                            if ($statu == 60) {
                                app('App\Http\Controllers\TransportRequestController')->verimorSendSms(
                                    $order->consumer->phone,
                                    $cargoMessage
                                );

                                app('App\Http\Controllers\TransportRequestController')->verimorSendSms(
                                    $order->consumer->phone,
                                    $surveyMessage
                                );
                            }
                        }
                    }
                }
            }
        }

        if ($this->data['method'] == 'synchronize-freight') {
            $user = $this->data['user_id'];
            $order = $this->data['order'];
            $cargoPrice = 0;

            $logs = VorwerkOrderLog::where('order_id', $order->id)->pluck('type_key')->toArray();
            $exist_log = in_array('synchronize-desi', $logs);

            if (!$exist_log) {
                $upsgetFreight = $this->upsgetFreight($session, $order->gonderi_takip_no);

                if (!empty($upsgetFreight)) {
                    $actualWeight = ($upsgetFreight->ActualWeight == 0.00) ? 0.01 : $upsgetFreight->ActualWeight;
                    $volumeWeight = ($upsgetFreight->VolumeWeight == 0.00) ? 0.01 : $upsgetFreight->VolumeWeight;
                    $gateways = array($actualWeight, $volumeWeight);
                    $desi = array_reduce(
                        $gateways, function ($a, $b) {
                            return $a ? ($a > $b ? $a : $b) : $b;
                        }
                    );

                    if (ceil((float)$desi) <= 50) {
                        $upsPrice = UPSCargoPrice::select('price')->whereRaw('? >= min_desi', [ceil((float)$desi)])->whereRaw('? <= max_desi', [ceil((float)$desi)])->first();
                        $cargoPrice = $upsPrice->price;
                    } else {
                        $maxRange = UPSCargoPrice::max('max_desi');
                        $unitPrice = UPSCargoPrice::select('price')->where('key', 'unit')->first();

                        $firstPart = UPSCargoPrice::select('price')->where('max_desi', $maxRange)->first();
                        $secondPart = (ceil((float)$desi) - $maxRange) * $unitPrice->price;
                        $cargoPrice = $firstPart->price + $secondPart;
                    }


                    VorwerkOrder::where('id', $order->id)
                        ->update(
                            [
                                'actualWeight' => $upsgetFreight->ActualWeight,
                                'volumeWeight' => $upsgetFreight->VolumeWeight,
                                'desi' => $desi,
                                'freight' => $upsgetFreight->Freight,
                                'cargoPrice' => $cargoPrice
                            ]
                        );

                    $orderLog = new VorwerkOrderLog();
                    $orderLog->user_id = $user;
                    $orderLog->order_id = $order->id;
                    $orderLog->type_key = 'synchronize-desi';
                    $orderLog->description = 'Desi bilgisi için senkronizasyon işlemi gerçekleştirilmiştir.';
                    $orderLog->save();
                }
            }
        }
    }
}
