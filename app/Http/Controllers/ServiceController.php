<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\City;
use App\Models\Town;
use App\Models\IrisCode;
use App\Models\Consumer;
use App\Models\Product;
use App\Models\Part;
use App\Models\ServiceClaim;
use App\Models\ServiceClaimDetail;
use App\Models\ServiceClaimExpense;
use App\Models\ServiceClaimDetailPart;
use App\Models\ServiceClaimAddress;
use App\Models\ServiceClaimNote;
use Response;
use Str;
use Auth;

class ServiceController extends Controller
{
    public function customerAcceptanceForm()
    {
        $title = "Müşteri Kabul Formu";
        $stores = Store::where('status', 1)->get();
        $cities = City::get();
        $iris_categories = IrisCode::select('iris_kategori_kod', 'iris_kategori_desc')
            ->where('iris_type', 'SYMPTOM-MÜŞTERİ NE DEDİ?')
            ->where('tip', 1)
            ->groupBy('iris_kategori_kod', 'iris_kategori_desc')
            ->get();

        return view('service.customer-acceptance-form', compact('stores', 'cities', 'iris_categories', 'title'));
    }

    public function consumerServiceClaims(Request $request)
    {
        $consurmerServiceClaims = ServiceClaim::select(
            'service_claim_details.product_name AS product_name',
            'services.servis_adi AS service_name',
            'service_claims.created_at AS created_at'
        )
            ->leftJoin('services', 'services.id', '=', 'service_claims.service_id')
            ->leftJoin('consumers', 'consumers.id', '=', 'service_claims.consumer_id')
            ->leftJoin('service_claim_details', 'service_claim_details.service_claim_id', '=', 'service_claims.id')
            ->where('consumers.id', $request->consumerID)
            ->get();

        return $consurmerServiceClaims;
    }

    public function towns(Request $request)
    {
        $response = Town::where('city_id', $request->city_id)->get();

        return $response;
    }

    public function productSearch(Request $request)
    {
        $products = Product::where('product_name', 'like', '%' . $request->q . '%')
            ->orWhere('product_code', 'like', '%' . $request->q . '%')
            ->get();

        return json_encode($products);
    }

    public function checkWarranty(Request $request)
    {
        // $data = [
        //     'query' => [ 'garantiKodu' => $request->garantiKodu, 'urunKodu' => $request->urunKodu, 'satis_tarihi' => $request->satis_tarihi]
        // ];

        // $client = new \GuzzleHttp\Client(
        //     [
        //         'verify' => false
        //     ]
        // );

        // $response = $client->request('GET', config('app.api_url').'checkGarantiDurum', $data);
        // return $response->getBody();
        return true;
    }

    public function getIrisCodes(Request $request)
    {
        $irisCodes = IrisCode::where('iris_type', 'SYMPTOM-MÜŞTERİ NE DEDİ?')
            ->where('iris_kategori', $request->iris_kategori)
            ->where('iris_kategori_kod', $request->iris_kategori_kod)
            ->whereIn('rcl', ['Y', 'N'])
            ->get();

        return $irisCodes;
    }

    public function createClaim(Request $request)
    {
        $user_id = Auth::user()->id;
        $service_id = Auth::user()->service_id;
        $consumer = Consumer::find($request->consumerID);

        if ($consumer) {
            $consumerID = $consumer->id;
        } else {
            $newConsumer = new Consumer();
            $newConsumer->guid         = Str::uuid();
            $newConsumer->firstName    = $request->consumerFirstName;
            $newConsumer->lastName     = $request->cosnuemrLastName;
            $newConsumer->phone        = $this->telclear($request->consumerMobilePhone);
            $newConsumer->save();
            $consumerID = $newConsumer->id;
        }

        $claim = new ServiceClaim();
        $claim->user_id = $user_id;
        $claim->consumer_id = $consumerID;
        $claim->service_id = $service_id;
        $claim->guid = Str::uuid();
        $claim->status = 1001;
        $claim->sms_check = 0;
        $claim->save();

        if ($claim->id) {
            $claimDetail = new ServiceClaimDetail();
            $claimDetail->service_claim_id = $claim->id;
            $claimDetail->barcode = str_pad($claim->id, 6, "0", STR_PAD_LEFT).random_int(100000, 999999);
            $claimDetail->product_name = $request->product_name;
            $claimDetail->product_code = $request->product_code;
            $claimDetail->product_serial_number = $request->product_serial_number;
            $claimDetail->sale_date = $request->sale_date;
            $claimDetail->store_bought = $request->store_bought;
            $claimDetail->warranty_code = $request->warranty_code;
            $claimDetail->has_warranty_card = isset($request->no_warranty_card) ? 0 : 1;
            $claimDetail->has_warranty = $request->has_warranty;
            $claimDetail->symptom_category = $request->complaint_category;
            $claimDetail->symptom_code = $request->complaint_code;
            $claimDetail->description = $request->complaint_text;
            $claimDetail->save();

            $adres = new ServiceClaimAddress();
            $adres->teslimEden = $request->teslim_eden;
            $adres->gonderen_ad_soyad = preg_replace('/\D+/', '', $request->gonderen_telefon);
            $adres->gonderen_telefon = $request->gonderen_telefon;
            $adres->kargo_sirketi = $request->kargo_sirketi;
            $adres->kargo_takip_no = $request->kargo_takip_no;
            $adres->kargo_teslim_tarihi = $request->kargo_teslim_tarihi;
            $adres->musteri_kodu = $request->musteri_kodu;
            $adres->magaza_takip_kodu = $request->magaza_takip_kodu;
            $adres->diger_ad_soyad = $request->diger_ad_soyad;
            $adres->diger_telefon = preg_replace('/\D+/', '', $request->diger_telefon);
            $adres->service_claim_id = $claim->id;
            $adres->save();
        }

        return redirect()->route('service.viewClaim', ['claimKey' => $claim->id]);
        // return redirect()->back();
    }

    public function pendingApproval()
    {
        $claims = ServiceClaim::with('service', 'service_claim_detail', 'service_claim_address', 'user', 'consumer')
            ->where('status', 1001)
            ->where('service_id', Auth::user()->service_id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('service.pending-approval', compact('claims'));
    }

    /**
     * Servis Claim Detay Görüntüleme ve Form Yazdırma Sayfası
     *
     * @param Request $request
     * @param [type] $claimKey
     * @return void
     */
    public function viewClaim(Request $request, $claimKey)
    {
        $title = "Servis Formu";
        $claim = ServiceClaim::with('consumer')->find($claimKey);

        return view('service.claim_view', compact('title', 'claim'));
    }

    public function technicalAnalysisForm()
    {
        $claims = ServiceClaim::with('service', 'service_claim_detail', 'service_claim_address', 'user', 'consumer')
            ->where('status', 1002)
            ->where('service_id', Auth::user()->service_id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('service.technical-analysis-form', compact('claims'));
    }

    public function technicalAnalysisDetail($id)
    {
        $claim = ServiceClaim::with('service', 'service_claim_detail', 'service_claim_address', 'user', 'consumer')->find($id);
        $product_iris = Product::select('iris_kategori', 'iris_kategori_description')->where('product_code', $claim->service_claim_detail->product_code)->first();
        $parts = @Part::where('product_sap_code', $claim->service_claim_detail->product_sap_code)->get();
        $addedParts = @ServiceClaimDetailPart::with('parts_detail')->where('claim_detail_id', $claim->service_claim_detail->id)->get();
        $addedExpenses = @ServiceClaimExpense::where('service_claim_detail_id', $claim->service_claim_detail->id)->get();
        $stores = Store::has('users')->where('status', 1)->get();
        $neresi_arizali = IrisCode::select('iris_kategori_kod', 'iris_kategori_desc')
            ->where('iris_kategori', $product_iris->iris_kategori)
            ->where('iris_type', 'SECTION-NERESİ ARIZALI?')
            ->where('tip', 1)
            ->groupBy('iris_kategori_kod', 'iris_kategori_desc')
            ->orderBy('iris_kategori_desc', 'ASC')
            ->get();

        $neden_arizalandi = IrisCode::select('iris_kategori_kod', 'iris_kategori_desc')
            ->where('iris_kategori', $product_iris->iris_kategori)
            ->where('iris_type', 'DEFECT-NEDEN ARIZALANDI?')
            ->where('tip', 1)
            ->groupBy('iris_kategori_kod', 'iris_kategori_desc')
            ->orderBy('iris_kategori_desc', 'ASC')
            ->get();


        $nasil_cozulecek = IrisCode::select('iris_kategori_kod', 'iris_kategori_desc')
            ->where('iris_kategori', $product_iris->iris_kategori)
            ->where('iris_type', 'REPAIR-NASIL ÇÖZECEKSİN?')
            ->where('tip', 1)
            ->groupBy('iris_kategori_kod', 'iris_kategori_desc')
            ->orderBy('iris_kategori_desc', 'ASC')
            ->get();
        $say = 1;

        return view('service.technical-analysis-detail', compact('claim', 'product_iris', 'parts', 'addedParts', 'addedExpenses', 'stores', 'neresi_arizali', 'neden_arizalandi', 'nasil_cozulecek', 'say'));
    }

    public function claimAction(Request $request)
    {
        $claim = explode('-', $request->claim_id);
        $claim_detail = ServiceClaimDetail::find($claim[1]);
        $product = Product::where('product_code', $claim_detail->product_code)->first();

        $neresi_arizali = [];
        $neden_arizalandi = [];
        $nasil_cozulecek = [];

        $neresi_arizali = IrisCode::select('iris_kategori_kod', 'iris_kategori_desc')
            ->where('iris_kategori', $product->iris_kategori)
            ->where('iris_type', 'SECTION-NERESİ ARIZALI?')
            ->where('tip', 1)
            ->groupBy('iris_kategori_kod', 'iris_kategori_desc')
            ->orderBy('iris_kategori_desc', 'ASC')
            ->get();

        $neden_arizalandi = IrisCode::select('iris_kategori_kod', 'iris_kategori_desc')
            ->where('iris_kategori', $product->iris_kategori)
            ->where('iris_type', 'DEFECT-NEDEN ARIZALANDI?')
            ->where('tip', 1)
            ->groupBy('iris_kategori_kod', 'iris_kategori_desc')
            ->orderBy('iris_kategori_desc', 'ASC')
            ->get();


        $nasil_cozulecek = IrisCode::select('iris_kategori_kod', 'iris_kategori_desc')
            ->where('iris_kategori', $product->iris_kategori)
            ->where('iris_type', 'REPAIR-NASIL ÇÖZECEKSİN?')
            ->where('tip', 1)
            ->groupBy('iris_kategori_kod', 'iris_kategori_desc')
            ->orderBy('iris_kategori_desc', 'ASC')
            ->get();

        return Response::json(
            array(
                'claim_id'          => $claim[0],
                'claim_detail_id'   => $claim[1],
                'product'           => $product,
                'product_id'        => $product->id,
                'product_name'      => $product_name,
                'product_code'      => $product_code,
                'product_iris'  => $product_iris,
                'parts'             => $parts,
                'add_parts'         => $add_parts,
                'iris_kategori'     => $product->iris_kategori,
                'musteri_nededi'    => $musteri_nededi,
                'musteri_nededi_iris_x' => $musteri_nededi_iris_x,
                'neresi_arizali'    => $neresi_arizali,
                'neden_arizalandi'  => $neden_arizalandi,
                'nasil_cozulecek'   => $nasil_cozulecek
            )
        );
    }

    public function claimAddPart(Request $request)
    {
        $varMi = ServiceClaimDetailPart::where('parts_sap_code', $request->part_value)->where('service_claim_id', $request->claim_id)->exists();
        if ($varMi) {
            return response()->json(['statu' => 'error', 'message' => 'Aynı yedek parçadan birden fazla ekleyemezsiniz!!!']);
        } else {
            $part = new ServiceClaimDetailPart();
            $part->service_claim_id = $request->claim_id;
            $part->claim_detail_id = $request->claim_detail_id;
            $part->parts_sap_code = $request->part_value;
            $part->garanti = $request->garanti;
            $part->save();

            $id = $part->id;
            $garanti = $request->garanti;

            $c = null;
            $pr = Part::where('parts_sap_code', $request->part_value)->first();
            if ($garanti == 1) {
                $garantiDurum = 'Garanti Dahili';
                $price = 0;
            } else {
                $garantiDurum = 'Garanti Harici';
                $price = $pr->parts_price;
            }
            $c .= '<tr id="row'.$id.'"><td>' . $pr->parts_sap_code . '</td><td>' . $pr->parts_product_code . '</td><td>' . $pr->parts_product_name . '</td><td>' . $garantiDurum . '</td>';
            $c .= '<td>' . $price . ' ₺</td><td><button type="button" name="remove" id="'.$id.'" class="btn btn-danger btn-sm px-3 py-1 me-2 mb-2 btn_remove">SİL</button></td></tr>';
            return $c;
        }
    }

    public function claimRemovePart()
    {
        ServiceClaimDetailPart::destroy($_GET['id']);
    }

    public function claimPartWarrantyCheck(Request $request)
    {
        $garanti = ServiceClaimDetailPart::where('claim_detail_id', $request->claim_detail_id)->where('garanti', 0)->count();
        $claim_parts = ServiceClaimDetailPart::where('claim_detail_id', $request->claim_detail_id)->count();

        if ($garanti == $claim_parts) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function claimAddExpense(Request $request)
    {
        $expense = new ServiceClaimExpense();
        $expense->service_claim_detail_id = $request->claim_detail_id;
        $expense->expense_type = $request->tip;
        $expense->expense_amount = $request->tutar;
        $expense->save();

        $data = null;

        if($expense->expense_type == 'kargo') {
            $gider = 'Kargo';
        } else if($expense->expense_type == 'eve_servis') {
            $gider = 'Eve Servis';
        } else if($expense->expense_type == 'harici_parca') {
            $gider = 'Harici Parça';
        } else {
            $gider = 'Diğer';
        }

        $data .= '<tr id="row'.$expense->id.'"><td>' . $gider . '</td><td>' . $expense->expense_amount . ' ₺</td>';
        $data .= '<td><button type="button" name="remove" id="'.$expense->id.'" class="btn btn-light-danger btn-sm px-3 py-1 me-2 mb-2 btn_remove_expense"><i class="bi bi-trash pe-0"></i></button></td></tr>';

        return response()->json(['success' => true, 'message' => 'Harici gider başarıyla eklenmiştir.', 'data' => $data]);
    }

    public function claimRemoveExpense()
    {
        ServiceClaimExpense::destroy($_GET['id']);
    }

    public function sectionCode()
    {
        $i = explode('-', $_GET['neden']);

        $iriskod = IrisCode::where('iris_kategori', $_GET['kat'])
            ->where('iris_type', 'SECTION-NERESİ ARIZALI?')
            ->where('iris_kategori_kod', $i[0])
            ->whereIn('rcl', ['Y', 'N'])
            ->orderBy('iris_code_tr', 'ASC')
            ->get();
        $select = '<select id="neresi_arizali_iris" name="neresi_arizali_iris" class="form-control" required>';
        foreach ($iriskod as $ik) {
            $desc = $ik->iris_code_tr;
            if ($ik->iris_code_tr == '#YOK') {
                $desc = $ik->iris_code_id.' - '.$ik->iris_code_tr;
            }
            $select .= '<option value="'.$desc.'">'.$desc.'</option>';
        }
        $select .= '</select>';
        return $select;
    }

    public function defectCode()
    {
        $i = explode('-', $_GET['neden']);

        $iriskod = IrisCode::where('iris_kategori', $_GET['kat'])
            ->where('iris_type', 'SYMPTOM-MÜŞTERİ NE DEDİ?')
            ->where('iris_kategori_kod', $i[0])
            ->whereIn('rcl', ['Y', 'N'])
            ->orderBy('iris_code_tr', 'ASC')
            ->get();
        $select = '<select id="neden_arizalandi_iris" name="neden_arizalandi_iris" class="form-control" required>';
        foreach ($iriskod as $ik) {
            $desc = $ik->iris_code_tr;
            if ($ik->iris_code_tr == '#YOK') {
                $desc = $ik->iris_code_id.' - '.$ik->iris_code_tr;
            }
            $select .= '<option value="'.$desc.'">'.$desc.'</option>';
        }
        $select .= '</select>';
        return $select;
    }

    public function repairCode()
    {
        $iriskod = IrisCode::where('iris_kategori', $_GET['kat'])
            ->where('iris_type', 'REPAIR-NASIL ÇÖZECEKSİN?')
            ->where('iris_kategori_kod', $_GET['neden'])
            ->whereIn('rcl', ['Y', 'N'])
            ->orderBy('iris_code_tr', 'ASC')
            ->get();
        $select = '<select id="nasil_cozeceksin_iris" name="nasil_cozeceksin_iris" class="form-control">';
        foreach ($iriskod as $ik) {
            $desc = $ik->iris_code_tr;
            if ($ik->iris_code_tr == '#YOK') {
                $desc = $ik->iris_code_id.' - '.$ik->iris_code_tr;
            }
            $select .= '<option value="'.$desc.'">'.$desc.'</option>';
        }
        $select .= '</select>';
        return $select;
    }

    public function claimSave(Request $request)
    {
        ServiceClaimDetail::where('id', $request->claim_detail_id)
            ->update(
                [
                    'store_bought' => $request->satin_alinan_magaza,
                    'sale_date' => $request->satis_tarihi,
                    'warranty_code' => $request->garanti_belgesi_kodu,
                    'has_warranty' => $request->garantili_mi,
                    'description' => $request->tuketici_sikayet,
                    'section_category' => $request->neresi_arizali,
                    'section_code' => $request->neresi_arizali_iris,
                    'defect_category' => $request->neden_arizali,
                    'defect_code' => $request->neden_arizalandi_iris,
                    'repair_category' => $request->nasil_cozulecek,
                    'repair_code' => $request->nasil_cozeceksin_iris,
                    'repair_completed' => $request->tamir,
                    'claim_type' => $request->claimType
                ]
            );

        if (!empty($request->servis_notu) or !empty($request->servis_dahili_notu)) {
            $servisNotu = new ServiceClaimNote();
            $servisNotu->service_claim_id = $request->claim;
            $servisNotu->user_id = auth()->id();
            $servisNotu->note_title = $request->servis_notu;
            $servisNotu->note = $request->servis_dahili_notu;
            $servisNotu->save();
        }

        return back()->with('msg', 'Ürün ayrıştırma işlemi başarıyla gerçekleşmiştir!');
    }

    public function claimApprove(Request $request)
    {
        ServiceClaim::where('id', $request->claim_id)->update(['status' => 1003]);
        ServiceClaimDetail::where('service_claim_id', $request->claim_id)->update(['shipping_date' => date('Y-m-d H:i:s')]);

        return redirect()->route('service.technical_analysis_form')->with('msg', 'Servis Onay İşlemi Başarıyla Gerçekleşmiştir! Talep No:'.$request->claim_id);
    }

    public function claimCargo(Request $request)
    {
        ServiceClaimDetail::where('service_claim_id', $request->claim_id)->update(['cargo_number' => $request->cargoNumber]);
        return back()->with('msg', 'Kargo Numarası başarılı bir şekilde güncellenmiştir.');
    }
}
