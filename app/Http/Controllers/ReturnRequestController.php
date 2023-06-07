<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Product;
use App\Models\Store;
use App\Models\History;
use App\Models\TransferType;
use App\Models\ReturnReason;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestDetail;
use App\Models\ReturnRequestNote;
use App\Models\ServiceClaim;
use App\Models\ServiceClaimDetail;
use App\Models\ServiceClaimAddress;
use App\Models\CustomerSale;
use App\Exports\ProgressPaymentExport;
use App\Imports\YGACargoImport;
use App\Jobs\RepairApprove;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use \Milon\Barcode\DNS1D;
use Str;

class ReturnRequestController extends Controller
{
    private function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function store()
    {
        $title = 'İade Talepleri';
        $returns = ReturnRequest::with('store', 'user')
            ->where('magaza_id', Auth::user()->magaza_id)
            ->where('tip', 1)
            ->orderby('id', 'desc')
            ->get();

        return view('returns.list', compact('title', 'returns'));
    }

    public function storeAll(Request $request)
    {
        $title = 'İade/Değişim Talepleri';

        if (!empty(Auth::user()->affiliated_company)) {
            $affiliatedCompanies = json_decode(Auth::user()->affiliated_company);
        } else {
            $affiliatedCompanies = [];
        }

        array_push($affiliatedCompanies,  Auth::user()->company_id);

        $products = Product::select('id', 'product_code', 'product_name')->whereIn('company_id', $affiliatedCompanies)->get();
        $returns = ReturnRequest::with('store', 'consumer')->whereIn('tip', [1,3]);

        if ($request->filter_return_id) {
            $returns->returnId($request->filter_return_id);
        }

        if ($request->filter_order_code) {
            $returns->orderCode($request->filter_order_code);
        }

        if ($request->filter_product) {
            $ids = ReturnRequestDetail::productQ($request->filter_product)->pluck('talep_id');
            $returns->whereIn('id', $ids);
        }

        if ($request->filter_consumer_firstname) {
            $consumers = Consumer::consumerFirstName($request->filter_consumer_firstname)->pluck('id');
            $returns->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_lastname) {
            $consumers = Consumer::consumerLastName($request->filter_consumer_lastname)->pluck('id');
            $returns->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_phone) {
            $consumers = Consumer::consumerPhone($request->filter_consumer_phone)->pluck('id');
            $returns->whereIn('consumer_id', $consumers);
        }

        $returns = $returns->orderby('id', 'desc')->paginate(30);
        $returns = $returns->appends($request->except('page'));

        return view('returns.general.list-all', compact('title', 'returns', 'products'));
    }

    /**
     * Genel Liste Modal Detayı - AJAX
     *
     * @param Request $request
     * @return void
     */
    public function generalDetail(Request $request)
    {
        $actionsDisabled = $request->action_type == 'return' ? false : true;
        $data = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name', 'rr.name as return_reason');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->leftJoin('return_reasons as rr', 'return_request_details.sebep', '=', 'rr.id');
                    $q->where('isOk', 0)->orwhere('isOk', 2);
                    $q->orderby('p.product_code', 'asc');
                },
                'consumer'
            ]
        )->find($request->id);

        $log = History::with('kullanici')
            ->where('talep_id', $request->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('returns.general.partials.detail-modal-template', compact('data', 'actionsDisabled', 'log'));
    }

    public function orderCancel(Request $request)
    {
        $title = 'İptal Talepleri';
        if (!empty(Auth::user()->affiliated_company)) {
            $affiliatedCompanies = json_decode(Auth::user()->affiliated_company);
        } else {
            $affiliatedCompanies = [];
        }

        array_push($affiliatedCompanies,  Auth::user()->company_id);

        $products = Product::select('id', 'product_code', 'product_name')->whereIn('company_id', $affiliatedCompanies)->get();
        $returns = ReturnRequest::with('consumer')->where('tip', 2);

        if ($request->filter_return_id) {
            $returns->returnId($request->filter_return_id);
        }

        if ($request->filter_order_code) {
            $returns->orderCode($request->filter_order_code);
        }

        if ($request->filter_product) {
            $ids = ReturnRequestDetail::productQ($request->filter_product)->pluck('talep_id');
            $returns->whereIn('id', $ids);
        }

        if ($request->filter_consumer_firstname) {
            $consumers = Consumer::consumerFirstName($request->filter_consumer_firstname)->pluck('id');
            $returns->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_lastname) {
            $consumers = Consumer::consumerLastName($request->filter_consumer_lastname)->pluck('id');
            $returns->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_phone) {
            $consumers = Consumer::consumerPhone($request->filter_consumer_phone)->pluck('id');
            $returns->whereIn('consumer_id', $consumers);
        }

        $returns = $returns->orderby('id', 'desc')->paginate(30);
        $returns = $returns->appends($request->except('page'));

        return view('returns.general.order-cancel', compact('title', 'products', 'returns'));
    }

    public function orderCancelConfirmed()
    {
        $title = 'Onaylanmış İptal Talepleri';
        $returns = ReturnRequest::with('consumer')
            ->where('tip', 2)
            ->where('status', '=', 8)
            ->orderby('id', 'desc')
            ->get();

        return view('returns.general.order-cancel-confirmed', compact('title', 'returns'));
    }

    public function orderCancelConfirm(Request $request)
    {
        try {
            ReturnRequest::where('id', $request->id)
                ->update([
                    'status' => 8
                ]);

            app('App\Http\Controllers\LogController')->create('Talep onaylandı**'.Auth::user()->id, $request->id, 'İptal talebi onaylandı', 6, 8);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    public function orderCancelRejected()
    {
        $title = 'Reddedilmiş İptal Talepleri';
        $returns = ReturnRequest::with('consumer')
            ->where('tip', 2)
            ->where('status', 9999)
            ->orderby('id', 'desc')
            ->get();

        return view('returns.general.order-cancel-rejected', compact('title', 'returns'));
    }

    public function orderCancelReject(Request $request)
    {
        try {
            ReturnRequest::where('id', $request->id)
                ->update([
                    'status' => 9999
                ]);

            app('App\Http\Controllers\LogController')->create('Talep iptal edildi**'.Auth::user()->id, $request->id, 'İptal talebi reddedildi', 6, 9999);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    public function orderCancelConvertToReturn(Request $request)
    {
        try {
            ReturnRequest::where('id', $request->id)
                ->update([
                    'tip' => 1
                ]);

            app('App\Http\Controllers\LogController')->create('Talep değiştirildi**'.Auth::user()->id, $request->id, 'İade talebine dönüştürüldü', 6, 8);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    public function ygaCargoManagement()
    {
        $title = 'YeniGibiAl Kargo Yönetimi';
        return view('returns.yga_cargo_management', compact('title'));
    }

    public function ygaCargoManagementImport(Request $request)
    {
        Excel::import(new YGACargoImport(), $request->file('importFile'));
        return back()->with('msg', 'Yenigibial Kargo Kodları Başarıyla Eklenmiştir.');
    }

    public function create()
    {
        $title = 'Yeni İade Talebi';

        if (!empty(Auth::user()->affiliated_company)) {
            $affiliatedCompanies = json_decode(Auth::user()->affiliated_company);
        } else {
            $affiliatedCompanies = [];
        }

        array_push($affiliatedCompanies,  Auth::user()->company_id);

        $products = Product::select('product_code', 'product_name')->whereIn('company_id', $affiliatedCompanies)->get();
        $stores = Store::select('id', 'name')->where('magaza_tipi', 'GSSubMagaza')->get();
        $reasons = ReturnReason::all();
        return view('returns.create', compact('title', 'products', 'stores', 'reasons'));
    }

    public function save(Request $request)
    {
        try {
            $rows = $request->product;

            $return = new ReturnRequest();
            $return->user_id     = Auth::user()->id;
            $return->magaza_id   = $request->store_id ?? Auth::user()->magaza_id;
            $return->consumer_id = $request->consumerID ?? 0;
            $return->status      = (Auth::user()->company_id == 1) ? 2 : 101;
            $return->tip         = 1;
            $return->adet        = array_sum(array_column($rows, 'quantity'));
            $return->kalem       = 0;
            $return->koli        = $request->koli ?? 1;
            $return->refundOrderNumber = $request->orderId ?? '';
            $return->save();

            foreach ($rows as $row) {
                $product = Product::where('product_code', $row['product_code'])->first();

                for ($i=0; $i < $row['quantity']; $i++) {
                    $detail = new ReturnRequestDetail();
                    $detail->talep_id = $return->id;
                    $detail->product_id = $product->id;
                    $detail->sebep = $row['reason'] ?? 9999;
                    $detail->ariza = $row['description'];
                    $detail->isOk = 0;
                    $detail->guid = $this->GUID();
                    $detail->barkod = str_pad($return->id, 6, "0", STR_PAD_LEFT).random_int(100000, 999999);
                    $detail->save();
                }
            }

            if ($return->status == 2) {
                app('App\Http\Controllers\LogController')->create('Talep açıldı**'.Auth::user()->id, $return->id, $request->note_onay, 0, 2);
                return redirect()->route('returns.product_acceptance.expected_list')->with('msg', 'İade Talebi Başarıyla Oluşturulmuştur! İade No:'.$return->id);
            } else {
                app('App\Http\Controllers\LogController')->create('Talep açıldı**'.Auth::user()->id, $return->id, $request->note_onay.'['.$request->koli.' koli]', 0, 101);
                return redirect()->route('returns.show')->with('msg', 'İade Talebi Başarıyla Oluşturulmuştur! İade No:'.$return->id);
            }


        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Exel ile iade listesi yükleme
     *
     * @param Request $request
     * @return void
     *
     * TODO: iade taleplerinin excel ile yüklenmesi sağlanacak.
     */
    public function createWithExcell(Request $request)
    {
        $title = "Excel ile iade talebi oluştur";

        return view('returns.create-with-excel', compact('title'));
    }

    public function invoices()
    {
        $title = "Faturası Kesilecekler";
        $returns = ReturnRequest::with('store', 'user')
            ->where('magaza_id', Auth::user()->magaza_id)
            ->where('status', 9)
            ->where('fatura_kontrol', -1)
            ->get();

        return view('returns.invoices', compact('returns', 'title'));
    }

    public function invoiceDetail($id)
    {
        $title = $id . "-" . "Talep Detayı";
        $return = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name', 'rr.name as return_reason');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->leftJoin('return_reasons as rr', 'return_request_details.sebep', '=', 'rr.id');
                    $q->where('iade_durumu', 1);
                    $q->orderby('p.product_code', 'asc');
                },
                'user',
                'store'
            ]
        )->find($id);

        $returnDetails = DB::select(
            '
            select
                d.ayristirma_id,
                d.iade_kabul_nedeni,
                count(*) as adet,
                sum(d.birimfiyat) as fiyat
            from return_request_details as d
            where d.talep_id = '.$id.' and
            d.isOk = 0
            group by
                d.ayristirma_id,
                d.iade_kabul_nedeni
            '
        );

        $log = History::with('kullanici')
            ->where('talep_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $kesinti = 0;
        $kesintiFiyat = 0;
        $say = 1;

        return view('returns.invoice-detail', compact('return', 'returnDetails', 'log', 'kesinti', 'kesintiFiyat', 'say', 'title'));
    }

    public function salesStore()
    {
        $title = 'Onay Bekleyen Mağaza İadeleri';
        $mgzs = Store::select('id')->where('satis_temsilcisi', Auth::user()->id)->get();

        $returns = ReturnRequest::with('store', 'user')
            ->where('tip', 1)
            ->where('status', 101)
            ->whereIn('magaza_id', $mgzs)
            ->orderBy('id', 'desc')
            ->get();

        return view('returns.sales.list', compact('title', 'returns'));
    }

    public function salesDetail($id)
    {
        $title = $id . '-' . 'Talep Detayı';
        $return = ReturnRequest::with('store', 'user', 'details')->find($id);
        $returnDetails = DB::select(
            '
            select
                p.product_code,
                d.product_id,
                rr.id as return_reason_id,
                rr.name as return_reason,
                d.ariza,
                p.product_name,
                d.isOk,
                d.talep_id,
                count(*) as adet,
                sum(p.desi) as desi
            from return_request_details as d
            left join products p on d.product_id = p.id
            left join return_reasons rr on d.sebep = rr.id
            where d.talep_id = '.$id.'
            group by
                p.product_code,
                d.product_id,
                return_reason_id,
                return_reason,
                d.ariza,
                p.product_name,
                d.isOk,
                d.talep_id
            '
        );
        $log = History::with('kullanici')
            ->where('talep_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $toplamdesi=0;
        $say = 1;

        return view('returns.sales.detail', compact('return', 'returnDetails', 'log', 'toplamdesi', 'say', 'title'));
    }

    public function urunOnayST(Request $request)
    {
        $returnDetail = ReturnRequestDetail::where('product_id', $request->product_id)
            ->where('sebep', $request->sebep)
            ->where('talep_id', $request->talep_id)
            ->first();
        $product = Product::find($returnDetail->product_id);

        if ($returnDetail->isOk == 0) {
            ReturnRequestDetail::where('product_id', $request->product_id)->where('sebep', $request->sebep)->where('talep_id', $request->talep_id)->update([ 'isOk' => 1]);

            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $returnDetail->talep_id;
            $log->islem     = 'ST tarafından kabul edilmedi';
            $log->note      = 'Sap Code: '.$product->product_code.' - Sebep: '.config('sebportal.iadesebep.'.$returnDetail->sebep);
            $log->last_status = '101';
            $log->new_status  = '101';
            $log->save();
        }

        if ($returnDetail->isOk == 1) {
            ReturnRequestDetail::where('product_id', $request->product_id)->where('sebep', $request->sebep)->where('talep_id', $request->talep_id)->update([ 'isOk' => 0]);

            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $returnDetail->talep_id;
            $log->islem     = 'ST tarafından tekrar listeye eklendi';
            $log->note      = 'Sap Code: '.$product->product_code.' - Sebep: '.config('sebportal.iadesebep.'.$returnDetail->sebep);
            $log->last_status = '101';
            $log->new_status  = '101';
            $log->save();
        }
    }

    public function salesReturnApprove(Request $request)
    {
        ReturnRequest::where('id', $request->return_id)->update(['status' => 1]);
        app('App\Http\Controllers\LogController')->create('İade Ön Onaya Gönerildi', $request->return_id, $request->note_onay, 101, 1);

        $returnCount = ReturnRequestDetail::where('talep_id', $request->return_id)->where('isOk', 0)->count();
        ReturnRequest::where('id', $request->return_id)->update(['adet' => $returnCount]);

        return redirect()->route('returns.sales.list')->with('msg', 'İade Başarıyla Ön Onaya Gönerildi! İade No:'.$request->return_id);
    }

    public function salesReturnReject(Request $request)
    {
        ReturnRequest::where('id', $request->return_id)->update(['status' => 102]);
        app('App\Http\Controllers\LogController')->create('İade Satış Temsılcısı tarafından red edildi.', $request->return_id, $request->note_red, 101, 102);

        $returnCount = ReturnRequestDetail::where('talep_id', $request->return_id)->where('isOk', 0)->count();
        ReturnRequest::where('id', $request->return_id)->update(['adet' => $returnCount]);

        return redirect()->route('returns.sales.list')->with('msg', 'İade Red Edildi! İade No:'.$request->return_id);
    }

    public function preApprovalList()
    {
        $title = 'Onay Bekleyen Mağaza İadeleri';
        $returns = ReturnRequest::with('store', 'user')
            ->where('status', 1)
            ->where('tip', 1)
            ->orderby('id', 'desc')
            ->get();
        return view('returns.pre-approval.list', compact('returns', 'title'));
    }

    public function preApprovalDetail($id)
    {
        $title = $id . '-' . "Talep Detayı";
        $transfer = TransferType::all();
        $return = ReturnRequest::with('store', 'user', 'details')->find($id);
        $returnDetails = DB::select(
            '
            select
                p.product_code,
                d.product_id,
                rr.id as return_reason_id,
                rr.name as return_reason,
                d.ariza,
                p.product_name,
                d.isOk,
                d.talep_id,
                count(*) as adet,
                sum(p.desi) as desi
            from return_request_details as d
            left join products p on d.product_id = p.id
            left join return_reasons rr on d.sebep = rr.id
            where d.talep_id = '.$id.'
            group by
                p.product_code,
                d.product_id,
                return_reason_id,
                return_reason,
                d.ariza,
                p.product_name,
                d.isOk,
                d.talep_id
            '
        );
        $log = History::with('kullanici')
            ->where('talep_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        $toplamdesi=0;
        $say = 1;

        return view('returns.pre-approval.detail', compact('transfer', 'return', 'returnDetails', 'log', 'toplamdesi', 'say', 'title'));
    }

    public function urunOnayOO(Request $request)
    {
        $returnDetail = ReturnRequestDetail::where('product_id', $request->product_id)
            ->where('sebep', $request->sebep)
            ->where('talep_id', $request->talep_id)
            ->first();
        $product = Product::find($returnDetail->product_id);

        if ($returnDetail->isOk == 0) {
            ReturnRequestDetail::where('product_id', $request->product_id)->where('sebep', $request->sebep)->where('talep_id', $request->talep_id)->update([ 'isOk' => 2]);

            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $returnDetail->talep_id;
            $log->islem     = 'Önonay tarafından kabul edilmedi';
            $log->note      = 'Sap Code: '.$product->product_code.' - Sebep: '.config('sebportal.iadesebep.'.$returnDetail->sebep);
            $log->last_status = '1';
            $log->new_status  = '1';
            $log->save();
        }

        if ($returnDetail->isOk == 2) {
            ReturnRequestDetail::where('product_id', $request->product_id)->where('sebep', $request->sebep)->where('talep_id', $request->talep_id)->update([ 'isOk' => 0]);

            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $returnDetail->talep_id;
            $log->islem     = 'Önonay tarafından tekrar listeye eklendi';
            $log->note      = 'Sap Code: '.$product->product_code.' - Sebep: '.config('sebportal.iadesebep.'.$returnDetail->sebep);
            $log->last_status = '1';
            $log->new_status  = '1';
            $log->save();
        }
    }

    public function preApprovalApprove(Request $request)
    {
        if ($request->transfer == 1 or $request->transfer == 6) {
            ReturnRequest::where('id', $request->return_id)->update(['status' => 41, 'transfer' => $request->transfer]);
            app('App\Http\Controllers\LogController')->create('İade Ön Onay Tarafından Onaylandı', $request->return_id, $request->note_onay, 1, 41);
        } else {
            ReturnRequest::where('id', $request->return_id)->update(['status' => 2, 'transfer' => $request->transfer]);
            app('App\Http\Controllers\LogController')->create('İade Ön Onay Tarafından Onaylandı', $request->return_id, $request->note_onay, 1, 2);
        }

        return redirect()->route('returns.pre_approval.list')->with('msg', 'İade Transfer Onayı Başarıyla Gerçekleşmiştir! İade No:'.$request->return_id);
    }

    public function preApprovalReject(Request $request)
    {
        ReturnRequest::where('id', $request->return_id)->update(['status' => 3]);
        app('App\Http\Controllers\LogController')->create('İade Ön Onay Tarafından Reddedildi', $request->return_id, $request->note_red, 1, 3);

        return redirect()->route('returns.pre_approval.list')->with('msg', 'İade Red Edildi! İade No:'.$request->return_id);
    }

    public function productAcceptanceExpected()
    {
        $title = "Gelmesi Beklenenler";
        $returns = ReturnRequest::selectRaw(
            "return_requests.id,
            rrt.name AS line_type,
            return_requests.refundOrderNumber as order_number,
            return_requests.status,
            return_requests.adet,
            CASE
                WHEN return_requests.consumer_id IS NOT NULL THEN CONCAT(c.firstName, ' ', c.lastName)
                ELSE CONCAT(s.name, ' ', s.musteri_kodu)
            END AS customer,
            s.id AS store_id,
            s.name AS store_name,
            CASE
                WHEN return_requests.tip = 1 THEN 'iade_talebi'
                ELSE 'degisim_talebi'
            END AS type,
            return_requests.created_at")
            ->leftJoin('stores AS s', 's.id', '=', 'return_requests.magaza_id')
            ->leftJoin('consumers AS c', 'c.id', '=', 'return_requests.consumer_id')
            ->leftJoin('return_request_types AS rrt', 'rrt.id', '=', 'return_requests.tip')
            ->where('return_requests.status', 2)
            ->whereIn('return_requests.tip', [1,3]);

        $data = ServiceClaim::selectRaw(
            "service_claims.id,
            'SERVİS TALEBİ' AS line_type,
            '-' as order_number,
            service_claims.status,
            '1' as adet,
            CONCAT(c2.firstName, ' ', c2.lastName) as customer,
            '0' as store_id,
            '-' as store_name,
            'servis_talebi' as type,
            service_claims.created_at")
            ->leftJoin('consumers as c2', 'c2.id', '=', 'service_claims.consumer_id')
            ->where('status', 1001)
            ->union($returns)
            ->get();

        return view('returns.product-acceptance.expected-list', compact('data', 'title'));
    }

    public function productAcceptanceAccept(Request $request)
    {
        if ($request->talep_type == 'iade_talebi' or $request->talep_type == 'degisim_talebi') {
            ReturnRequest::where('id', $request->talep_id)->update(['status' => 6]);
            app('App\Http\Controllers\LogController')->create('İade/Değişim Mal Kabul Tarafından Teslim Alındı', $request->talep_id, 'Kontrol edildi ve Teslim Alındı', 2, 6);
            return back()->with('msg', 'İade/Değişim Mal Kabul Tarafından Teslim Alındı! İade No:'.$request->talep_id);
        } else {
            ServiceClaim::where('id', $request->talep_id)->update(['status' => 1002]);
            ServiceClaimDetail::where('service_claim_id', $request->talep_id)->update(['shipping_date' => date('Y-m-d H:i:s')]);
            return back()->with('msg', 'Servis talebi mal kabul tarafından onaylandı ve atölyeye teslim edildi! Talep No:'.$request->talep_id);
        }
    }

    public function productAcceptanceCheckExpected()
    {
        $title = "Kontrol Bekleyenler";
        $returns = ReturnRequest::select(
                'return_requests.id AS id',
                'rrt.name AS line_type',
                'return_requests.refundOrderNumber as order_number',
                'return_requests.created_at AS created_at',
                'return_requests.adet AS adet',
                DB::raw('CONCAT(c.firstName," ",c.lastName) as consumer_name'))
            ->where('status', 6)
            ->leftJoin('consumers AS c', 'c.id', '=', 'return_requests.consumer_id')
            ->leftJoin('return_request_types AS rrt', 'rrt.id', '=', 'return_requests.tip')
            ->orderBy('id', 'desc')
            ->get();

        return view('returns.product-acceptance.check-expected-list', compact('returns', 'title'));
    }

    public function productAcceptanceDetail($id)
    {
        $title = $id . '-' . "Talep Detayı";
        $return = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name', 'rr.name as return_reason');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->leftJoin('return_reasons as rr', 'return_request_details.sebep', '=', 'rr.id');
                    $q->where('isOk', 0)->orwhere('isOk', 2);
                    $q->orderby('p.product_code', 'asc');
                },
                'consumer',
                'store'
            ]
        )->find($id);

        $log = History::with('kullanici')
            ->where('talep_id', $return->id)
            ->orderBy('id', 'desc')
            ->get();

        $say = 1;

        return view('returns.product-acceptance.detail', compact('return', 'log', 'say', 'title'));
    }

    public function searchProduct(Request $request)
    {
        if (!empty(Auth::user()->affiliated_company)) {
            $affiliatedCompanies = json_decode(Auth::user()->affiliated_company);
        } else {
            $affiliatedCompanies = [];
        }

        array_push($affiliatedCompanies,  Auth::user()->company_id);

        $products = Product::select('id', 'ean', 'product_name', 'product_code')
            ->whereIn('company_id', $affiliatedCompanies)
            ->where('product_name', 'like', '%'.$request->data.'%')
            ->Orwhere('product_sap_code', 'like', '%'.$request->data.'%')
            ->Orwhere('product_code', 'like', '%'.$request->data.'%')
            ->get();

        $sonuc = '';

        foreach ($products as $p) {
            $js = "revizyon('".$request->detay."','".$p->id."')";

            $sonuc .= '<a onclick="'.$js.'" class="btn btn-sm text-start">';
            $sonuc .= $p->product_code.' - '.$p->product_name.'</a><br>';
        }

        return $sonuc;
    }

    public function revizyon(Request $request)
    {
        $returnDetail = ReturnRequestDetail::find($request->id);
        $product = Product::where('id', $request->rev)->first();
        ReturnRequestDetail::where('id', $request->id)->update(
            [
                'revizyon_product_id' => $request->rev,
                'product_name' => $product->product_name,
                'product_code' => $product->product_code
            ]
        );

        $log = new History();
        $log->user_id   = Auth::user()->id;
        $log->talep_id  = $returnDetail->talep_id;
        $log->islem     = 'Mal Kabul tarafından ürün revize edildi';
        $log->note      = 'Eski Ürün : '.$returnDetail->product_code.' -> Yeni Ürün : '.$product->product_code.' Talep Detay ID : '.  $returnDetail->id;
        $log->last_status = '6';
        $log->new_status  = '6';
        $log->save();

        return $product;
    }

    public function urunOnayMK(Request $request)
    {
        $returnDetail = ReturnRequestDetail::find($request->id);
        $product = Product::find($returnDetail->product_id);

        if ($returnDetail->isOk == 0) {
            ReturnRequestDetail::where('id', $request->id)->update(['isOk' => 3]);

            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $returnDetail->talep_id;
            $log->islem     = 'Mal Kabul tarafından gelmediği belirtildi';
            $log->note      = 'Ürün Kodu: '.$product->product_code.' - Sebep: '.config('sebportal.iadesebep.'.$returnDetail->sebep);
            $log->last_status = '6';
            $log->new_status  = '6';
            $log->save();
        }

        if ($returnDetail->isOk == 3) {
            ReturnRequestDetail::where('id', $request->id)->update(['isOk' => 0]);

            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $returnDetail->talep_id;
            $log->islem     = 'IOM Kabul tekrar listeden onaylandı';
            $log->note      = 'Ürün Kodu: '.$product->product_code.' - Sebep: '.config('sebportal.iadesebep.'.$returnDetail->sebep);
            $log->last_status = '6';
            $log->new_status  = '6';
            $log->save();
        }
    }

    public function productAcceptanceBarcode($id)
    {
        $response = null;
        $returnDetail = ReturnRequestDetail::find($id);
        $product = Product::find($returnDetail->revizyon_product_id ?? $returnDetail->product_id);
        $return = ReturnRequest::with('store')->find($returnDetail->talep_id);
        $barcode = DNS1D::getBarcodePNG($returnDetail->barkod, 'C93', 1, 50, array(1,1,1), true);

        $response .= '<div style="width: 4.5cm; height: 2.7cm; padding-top: .3cm;">';
        $response .= '<img src="data:image/png;base64,' . $barcode .'" alt="barcode" style="width: 100%" />';
        $response .= '<div style="text-align: center; width: 100%; font-size: 10px; padding-top: .1cm;">';
        $response .= $product->product_code;
        $response .= '<div>'. $product->product_name.'</div>';
        $response .= '</div>';
        $response .= '</div>';
        return view('returns.product-acceptance.barcode', compact('response'));
    }

    public function productAcceptanceBulkBarcode(Request $request)
    {
        $response = null;
        $ids = explode(',', $request->choosen);
        $returnDetails = ReturnRequestDetail::whereIn('id', $ids)->get();

        foreach ($returnDetails as $item) {
            $return = ReturnRequest::with('store')->find($item->talep_id);
            $product = Product::find($item->revizyon_product_id ?? $item->product_id);
            $barcode = DNS1D::getBarcodePNG($item->barkod, 'C93', 1, 50, array(1,1,1), true);

            $response .= '<div style="width: 4.5cm; height: 2.7cm; padding-top: .3cm;">';
            $response .= '<img src="data:image/png;base64,' . $barcode .'" alt="barcode" style="width: 100%" />';
            $response .= '<div style="text-align: center; width: 100%; font-size: 10px; padding-top: .1cm;">';
            $response .= $product->product_code;
            $response .= '<div>'. $product->product_name.'</div>';
            $response .= '</div>';
            $response .= '</div>';
        }
        return view('returns.product-acceptance.bulk_barcode', compact('response'));
    }

    public function productAcceptanceImageCapture(Request $request)
    {
        $product_note = $request->saveImage[0]['value'];
        $image = $request->saveImage[1]['value'];
        $id = $request->saveImage[2]['value'];

        $folderPath = 'captures/';
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.jpeg';

        $file = $folderPath . $fileName;
        $response = File::put(public_path(). '/' . $file, $image_base64);

        if ($response) {
            $returnDetail = ReturnRequestDetail::find($id);
            $returnDetail->captured_image = $fileName;
            $returnDetail->product_note = $product_note;
            $returnDetail->save();

            return response()->json(['message' => 'success', 'image_name' => $fileName]);
        } else {
            return response()->json(['message'=>'error']);
        }
    }

    public function productAcceptanceApprove(Request $request)
    {
        $return = ReturnRequest::find($request->return_id);
        $returnCount = ReturnRequestDetail::where('isOk', 0)->where('talep_id', $request->return_id)->count();

        if ($return->status == 6 or $return->status == 5) {
            $return->adet = $returnCount;
            $return->status = 7;
            $return->fiz_lok = 3;
            $return->updated_at = date('Y-m-d H:i:s');
            $return->save();

            app('App\Http\Controllers\LogController')->create('İade/Değişim Kontrolü yapılarak Ayrıştırmaya sevkedildi', $request->return_id, $request->note_onay, 6, 7);

            return redirect()->route('returns.product_acceptance.check_expected_list')->with('msg', 'İade/Değişim Kontrolü Başarıyla Gerçekleşmiştir! İade No:'.$request->return_id);
        }
    }

    public function productAcceptanceDeniedList()
    {
        $title = "Reddedilenler";
        $returns = ReturnRequest::select('return_requests.id', 's.name as storeName', 'return_requests.created_at', 'return_requests.adet')
            ->leftJoin('return_request_details as rrd', 'rrd.talep_id', '=', 'return_requests.id')
            ->leftJoin('stores as s', 's.id', '=', 'return_requests.magaza_id')
            ->where('return_requests.status', 70)
            ->orWhere('rrd.iade_durumu', 3)
            ->orderby('return_requests.id', 'desc')
            ->get();

        return view('returns.product-acceptance.denied-list', compact('returns', 'title'));
    }

    public function productAcceptanceDeniedDetail($id)
    {
        $title = $id . '-' . "Telep Detayı";
        $return = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->orderby('p.product_code', 'asc');
                },
                'store',
                'user'
            ]
        )->find($id);

        $log = History::with('kullanici')
            ->where('talep_id', $return->id)
            ->orderBy('id', 'desc')
            ->get();

        $transfer = TransferType::all();

        $say = 1;
        $printSay = 1;

        return view('returns.product-acceptance.denied-detail', compact('return', 'log', 'transfer', 'say', 'printSay', 'title'));
    }

    public function dispatchPrint(Request $request)
    {
        ReturnRequest::where('id', $request->id)->update(['sevk_evrak' => 1]);
        app('App\Http\Controllers\LogController')
            ->create('Sevk Belgesi Yazdırıldı', $request->id, 'Sevk Belgesi Yazdırıldı', 70, 70);
    }

    public function productAcceptanceApproveDispatch(Request $request)
    {
        if ($request->transfer == 1) {
            ReturnRequest::where('id', $request->return_id)->update(['status' => 71, 'transfer' => $request->transfer, 'fiz_lok' => 3]);
            app('App\Http\Controllers\LogController')
                ->create('Biçözüm Tarafından Alınması Bekleniyor-Geri Gönderim**'.Auth::user()->id, $request->return_id, 'Geri Gönderim', 70, 71);
        } else {
            ReturnRequest::where('id', $request->return_id)->update(['status' => 73, 'transfer' => $request->transfer]);
            app('App\Http\Controllers\LogController')
                ->create('Mağazaya Teslim Edildi**'.Auth::user()->id, $request->return_id, 'Mağazaya Teslim Edildi', 70, 73);
        }

        return redirect()->route('returns.product_acceptance.denied_list')->with('msg', 'Mağaza İade Sevk İşlemi Başarıyla Gerçekleşmiştir! İade No:'.$request->return_id);
    }

    public function productAcceptanceToShipList()
    {
        $title = "Sevk Edilecekler";
        $returns = ReturnRequest::select('return_requests.id', 's.name as storeName', 'return_requests.created_at', 'rrd.printed_product_barcode')
            ->leftJoin('return_request_details as rrd', 'rrd.talep_id', '=', 'return_requests.id')
            ->leftJoin('stores as s', 's.id', '=', 'return_requests.magaza_id')
            ->where('rrd.iade_durumu', 1)
            ->orderby('return_requests.id', 'desc')
            ->get();

        return view('returns.product-acceptance.to-ship-list', compact('returns', 'title'));
    }

    public function repairList()
    {
        $title = "Tamir Yönetimi";
        $returns = ReturnRequest::selectRaw(
            "return_requests.id,
            rrt.name AS line_type,
            return_requests.refundOrderNumber as order_number,
            return_requests.status,
            return_requests.adet,
            CASE
                WHEN return_requests.consumer_id IS NOT NULL THEN CONCAT(c.firstName, ' ', c.lastName)
                ELSE CONCAT(s.name, ' ', s.musteri_kodu)
            END AS customer,
            s.id AS store_id,
            s.name AS store_name,
            CASE
                WHEN return_requests.tip = 1 THEN 'iade_talebi'
                ELSE 'degisim_talebi'
            END AS type,
            return_requests.created_at")
            ->leftJoin('stores AS s', 's.id', '=', 'return_requests.magaza_id')
            ->leftJoin('consumers AS c', 'c.id', '=', 'return_requests.consumer_id')
            ->leftJoin('return_request_types AS rrt', 'rrt.id', '=', 'return_requests.tip')
            ->where('return_requests.status', 7)
            ->get();

        return view('returns.repair.list', compact('returns', 'title'));
    }

    public function repairDetail($id)
    {
        $title = $id . '-' . "Talep Detayı";
        $tamam = false;
        $return = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name', 'rr.name as return_reason');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->leftJoin('return_reasons as rr', 'return_request_details.sebep', '=', 'rr.id');
                    $q->where('isOk', 0);
                    $q->orderby('p.product_code', 'asc');
                },
                'user',
                'store'
            ]
        )->find($id);

        $detail = ReturnRequestDetail::where('isOk', 0)
            ->where('talep_id', $id)
            ->whereNotNull('ayristirma_id')
            ->orWhereIn('degisim_durumu', [1,2])
            ->count();

        if ($detail == count($return->details)) {
            $tamam = true;
        }

        $log = History::with('kullanici')
            ->where('talep_id', $return->id)
            ->orderBy('id', 'desc')
            ->get();

        $say = 1;

        return view('returns.repair.detail', compact('return', 'tamam', 'log', 'say', 'title'));
    }

    public function repairAction(Request $request)
    {
        $return = explode('-', $request->return_id);
        $return_request = ReturnRequest::find($return[0]);
        $return_detail = ReturnRequestDetail::find($return[1]);
        $product = Product::find($return_detail->revizyon_product_id ?? $return_detail->product_id);
        $product_name = $product->product_name;
        $product_code = $product->product_code;

        return Response::json(
            array(
                'return_id'         => $return[0],
                'return_detail_id'  => $return[1],
                'type'              => $return_request->tip,
                'product'           => $product,
                'product_id'        => $product->id,
                'product_name'      => $product_name,
                'product_code'      => $product_code
            )
        );
    }

    public function repairBarcodeAction(Request $request)
    {
        $return_detail = ReturnRequestDetail::where('barkod', $request->return_barcode)->first();
        $return_request = ReturnRequest::find($return_detail->talep_id);
        $product = Product::find($return_detail->revizyon_product_id ?? $return_detail->product_id);
        $product_name = $product->product_name;
        $product_code = $product->product_code;

        return Response::json(
            array(
                'return_id'         => $return_detail->talep_id,
                'return_detail_id'  => $return_detail->id,
                'type'              => $return_request->tip,
                'product'           => $product,
                'product_id'        => $product->id,
                'product_name'      => $product_name,
                'product_code'      => $product_code
            )
        );
    }

    public function repairProductBarcode(Request $request, $id)
    {
        $response = null;
        $returnDetail = ReturnRequestDetail::find($id);
        $product = Product::find($returnDetail->revizyon_product_id ?? $returnDetail->product_id);

        //$return = ReturnRequest::with('store')->find($returnDetail->talep_id);

        $productCode = explode('-', $product->product_code);

        switch ($request->ayristirma_id) {
        case 2:
            $ayristirmaID = '-A';
            break;
        case 3:
            $ayristirmaID = '-B';
            break;
        case 4:
            $ayristirmaID = '-C';
            break;
        case 5:
            $ayristirmaID = '-H';
            break;
        default:
            $ayristirmaID = '';
            break;
        }

        if (!empty($productCode[1])) {
            $productCode = str_replace($productCode[1], $ayristirmaID, str_replace('-', '', $product->product_code));
        } else {
            $productCode = $productCode[0].$ayristirmaID;
        }

        $checkProduct = Product::where('product_code', $productCode)->first();

        if (!empty($checkProduct)) {
            $barcode = DNS1D::getBarcodePNG($productCode, 'C93', 1, 50, array(1,1,1), true);
            $response .= '<div id="printable_barcode" style="width: 5cm; height: 3cm; padding: .1cm; margin: 0; overflow: hidden;">';
            $response .= '<img src="data:image/png;base64,' . $barcode .'" alt="barcode" style="width: 100%; margin: 0;" />';
            $response .= '<div style="text-align: center; width: 100%; font-size: 10px; padding-top: .1cm;">';
            $response .= '<div>'. $checkProduct->product_name.'</div>';
            $response .= '</div>';
            $response .= '</div>';

            ReturnRequestDetail::where('id', $id)->update(['printed_product_barcode' => $productCode]);

            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $returnDetail->talep_id;
            $log->islem     = 'Tekniker tarafından ürün için barkod basıldı';
            $log->note      = 'Ürün Kodu : '.$product->product_code.' -> Barkod : '.$productCode.' Talep Detay ID : '.  $returnDetail->id;
            $log->last_status = '7';
            $log->new_status  = '7';
            $log->save();

            return $response;
        } else {
            return $checkProduct;
        }
    }

    public function repairSave(Request $request)
    {
        ReturnRequestDetail::where('id', $request->return_detail_id)
            ->update(
                [
                    'iade_durumu' => $request->plan,
                    'degisim_durumu' => $request->changeplan,
                    'ayristirma_id' => $request->ayristirma_id
                ]
            );

        if (!empty($request->servis_notu) or !empty($request->servis_dahili_notu)) {
            $servisNotu = new ReturnRequestNote();
            $servisNotu->talep_id = $request->return_id;
            $servisNotu->talep_detay_id = $request->return_detail_id;
            $servisNotu->user_id = Auth::user()->id;
            $servisNotu->servis_notu = $request->servis_notu;
            $servisNotu->servis_dahili_notu = $request->servis_dahili_notu;
            $servisNotu->save();
        }

        $detailCount = ReturnRequestDetail::where('talep_id', $request->return_id)->count();
        $returnCount = ReturnRequestDetail::where('talep_id', $request->return_id)->whereNotNull('iade_durumu')->count();
        $changeCount = ReturnRequestDetail::where('talep_id', $request->return_id)->whereNotNull('degisim_durumu')->count();

        if (($detailCount == $returnCount) or ($detailCount == $changeCount)) {
            $data['id'] = $request->return_id;
            $data['user_id'] = Auth::user()->id;
            $data['note'] = '';
            RepairApprove::dispatchNow($data);

            return back()->with('msg', 'İade/Değişim Tamir İşlemi Başarıyla Gerçekleşmiştir! İade No:'.$request->return_id);
        } else {
            return back()->with('msg', 'Ürün ayrıştırma işlemi başarıyla gerçekleşmiştir! İade/Değişim Detay No:'.$request->return_detail_id);
        }
    }

    public function repairApprove(Request $request)
    {
        $data['id'] = $request->return_id;
        $data['user_id'] = Auth::user()->id;
        $data['note'] = '';
        RepairApprove::dispatch($data)->onQueue('notification');

        return redirect()->route('returns.repair.list')->with('msg', 'İade/Değişim Tamir İşlemi Başarıyla Gerçekleşmiştir! İade/Değişim No:'.$request->return_id);
    }

    public function repairConfirm($id, $user, $note)
    {
        $return = ReturnRequest::with('user', 'store')->find($id);

        if ($return->tip == 1) {
            $numberOfReturnApproved = ReturnRequestDetail::where('talep_id', $id)
                ->where('iade_durumu', 1)
                ->count();

            $numberOfReturnRepair = ReturnRequestDetail::where('talep_id', $id)
                ->where('iade_durumu', 2)
                ->count();

            $numberOfReturnReject = ReturnRequestDetail::where('talep_id', $id)
                ->where('iade_durumu', 3)
                ->count();

            if ($numberOfReturnApproved == 0 and $numberOfReturnRepair == 0) {
                ReturnRequest::where('id', $id)->update(['status' => 70, 'atolye_hakedis' => 1]);
                app('App\Http\Controllers\LogController')
                    ->create('Tamir yapılarak mağazaya geri gönderildi', $id, $note, 7, 70);
            }

            if ($numberOfReturnReject == 0 and $numberOfReturnRepair == 0) {
                $this->sendRefundPricing($id, $note);
            }

            if ($numberOfReturnRepair > 0) {
                $repairReturns = ReturnRequestDetail::where('talep_id', $id)
                    ->where('iade_durumu', 2)
                    ->get();

                $newClaim = new ServiceClaim();
                $newClaim->user_id = $return->user_id;
                $newClaim->consumer_id = $return->consumer_id;
                $newClaim->service_id = 1;
                $newClaim->guid = Str::uuid();
                $newClaim->status = 1001;
                $newClaim->sms_check = 0;
                $newClaim->save();

                foreach ($repairReturns as $item) {
                    $product = Product::find($item->revizyon_product_id ?? $item->product_id);
                    $newClaimDetail = new ServiceClaimDetail();
                    $newClaimDetail->service_claim_id = $newClaim->id;
                    $newClaimDetail->barcode = $item->barkod;
                    $newClaimDetail->product_name = $product->product_name;
                    $newClaimDetail->product_sap_code = $product->product_sap_code;
                    $newClaimDetail->product_code = $product->product_code;
                    $newClaimDetail->symptom_category = '5-Hasarlı Parça / Kırık / Ezik';
                    $newClaimDetail->symptom_code = '5231-..';
                    $newClaimDetail->save();
                }

                $adres = new ServiceClaimAddress();
                $adres->teslimEden = 4;
                $adres->service_claim_id = $newClaim->id;
                $adres->save();

                ReturnRequest::where('id', $id)->update(['status' => 8, 'related_service_claim_id' => $newClaim->id, 'adet' => $numberOfReturnApproved]);
                app('App\Http\Controllers\LogController')
                    ->create('İade tamiri yapılarak muhasebe sevkedildi', $id, $note, 7, 8);
            }

            if ($numberOfReturnApproved > 0 and $numberOfReturnReject > 0) {
                $rejectedReturns = ReturnRequestDetail::where('talep_id', $id)
                    ->where('iade_durumu', 3)
                    ->get();

                $newRefund = new ReturnRequest();
                $newRefund->user_id     = $return->user_id;
                $newRefund->magaza_id   = $return->magaza_id;
                $newRefund->consumer_id = 0;
                $newRefund->status      = 70;
                $newRefund->tip         = $return->tip;
                $newRefund->adet        = $numberOfReturnReject;
                $newRefund->kalem       = 0;
                $newRefund->fiz_lok     = 3;
                $newRefund->related_talep = $id;
                $newRefund->save();
                $returnID = $newRefund->id;

                ReturnRequest::where('id', $id)->update(['related_talep' => $returnID, 'adet' => $numberOfReturnApproved]);

                foreach ($rejectedReturns as $item) {
                    ReturnRequestDetail::where('id', $item->id)->update(['talep_id' => $returnID]);
                }

                app('App\Http\Controllers\LogController')->create('Tamir Yönetiminden den Mağazaya İade/Değişim Sevki Oluşturuldu**'.$user, $returnID, 'Mağazaya İade/Değişim Sevki', 0, 70);
                app('App\Http\Controllers\LogController')->create('Talep içinde mağazaya kısmi veya tam gönderim yapıldı**'.$user, $id, 'Talep içinde mağazaya kısmi veya tam gönderim yapıldı ID :'.$returnID, 0, 70);

                $this->sendRefundPricing($id, $note);
            }
        } else {
            $numberOfChangeApproved = ReturnRequestDetail::where('talep_id', $id)
                ->where('degisim_durumu', 1)
                ->count();

            $numberOfChangeRepair = ReturnRequestDetail::where('talep_id', $id)
                ->where('degisim_durumu', 2)
                ->count();

            if ($numberOfChangeApproved == 0) {
                $needRepairChanges = ReturnRequestDetail::where('talep_id', $id)
                    ->where('degisim_durumu', 2)
                    ->get();

                $newClaim = new ServiceClaim();
                $newClaim->user_id = $return->user_id;
                $newClaim->consumer_id = $return->consumer_id;
                $newClaim->service_id = 1;
                $newClaim->guid = Str::uuid();
                $newClaim->status = 1001;
                $newClaim->sms_check = 0;
                $newClaim->save();


                foreach ($needRepairChanges as $item) {
                    $product = Product::find($item->revizyon_product_id ?? $item->product_id);
                    $newClaimDetail = new ServiceClaimDetail();
                    $newClaimDetail->service_claim_id = $newClaim->id;
                    $newClaimDetail->barcode = $item->barkod;
                    $newClaimDetail->product_name = $product->product_name;
                    $newClaimDetail->product_sap_code = $product->product_sap_code;
                    $newClaimDetail->product_code = $product->product_code;
                    $newClaimDetail->symptom_category = '5-Hasarlı Parça / Kırık / Ezik';
                    $newClaimDetail->symptom_code = '5231-..';
                    $newClaimDetail->save();
                }

                $adres = new ServiceClaimAddress();
                $adres->teslimEden = 4;
                $adres->service_claim_id = $newClaim->id;
                $adres->save();

                ReturnRequest::where('id', $id)->update(['status' => 9999, 'related_service_claim_id' => $newClaim->id, 'adet' => 0]);

                app('App\Http\Controllers\LogController')
                    ->create('Değişim talebi tam olarak servis talebine dönüştürülmüştür', $id, $note, 7, 9999);
            }

            if ($numberOfChangeRepair == 0) {
                $this->sendRefundPricing($id, $note);
            }

            if ($numberOfChangeApproved > 0 and $numberOfChangeRepair > 0) {
                $needRepairChanges = ReturnRequestDetail::where('talep_id', $id)
                    ->where('degisim_durumu', 2)
                    ->get();

                $newClaim = new ServiceClaim();
                $newClaim->user_id = $return->user_id;
                $newClaim->consumer_id = $return->consumer_id;
                $newClaim->service_id = 1;
                $newClaim->guid = Str::uuid();
                $newClaim->status = 1001;
                $newClaim->sms_check = 0;
                $newClaim->save();


                foreach ($needRepairChanges as $item) {
                    $product = Product::find($item->revizyon_product_id ?? $item->product_id);
                    $newClaimDetail = new ServiceClaimDetail();
                    $newClaimDetail->service_claim_id = $newClaim->id;
                    $newClaimDetail->barcode = $item->barkod;
                    $newClaimDetail->product_name = $product->product_name;
                    $newClaimDetail->product_sap_code = $product->product_sap_code;
                    $newClaimDetail->product_code = $product->product_code;
                    $newClaimDetail->symptom_category = '5-Hasarlı Parça / Kırık / Ezik';
                    $newClaimDetail->symptom_code = '5231-..';
                    $newClaimDetail->save();
                }

                $adres = new ServiceClaimAddress();
                $adres->teslimEden = 4;
                $adres->service_claim_id = $newClaim->id;
                $adres->save();

                ReturnRequest::where('id', $id)->update(['status' => 15, 'related_service_claim_id' => $newClaim->id, 'adet' => $numberOfChangeApproved]);

                app('App\Http\Controllers\LogController')
                    ->create('Değişim talebi kısmi olarak servis talebine dönüştürülmüştür ve onaylanmıştır', $id, $note, 7, 15);
            }
        }
    }

    private function sendRefundPricing($id, $note)
    {
        $return = ReturnRequest::with('user', 'store')->find($id);

        if ($return->tip == 1) {
            $islem = 'İade tamiri yapılarak muhasebe sevkedildi';
            $statu = 8;
        } else {
            $islem = 'Değişim tamiri yapılarak onaya gönderildi';
            $statu = 15;
        }

        ReturnRequest::where('id', $id)->update(['status' => $statu, 'atolye_hakedis' => 1]);
            app('App\Http\Controllers\LogController')
                ->create($islem, $id, $note, 7, $statu);

        Artisan::call('app:set-iscilik --talep='.$id);
    }

    public function repairProgressPaymentList()
    {
        $returns = ReturnRequest::select('return_requests.*', 'logs.created_at as hakedisDate')
            ->leftJoin('logs', 'return_requests.id', '=', 'logs.talep_id')
            ->where('tip', 1)
            ->where('atolye_hakedis', 1)
            ->where('logs.last_status', 7)
            ->where(
                function ($q) {
                    $q->where('logs.new_status', 8)->orWhere('logs.new_status', 10)->orWhere('logs.new_status', 70);
                }
            )
            ->groupBy('return_requests.id', 'hakedisDate')
            ->get();

        $dates = ReturnRequest::select('faturalanma_tarihi')
            ->whereNotNull('faturalanma_tarihi')
            ->where('atolye_hakedis', 2)
            ->groupBy('faturalanma_tarihi')
            ->get();

        return view('returns.repair.repair-progress-list', compact('returns', 'dates'));
    }

    public function repairCreateProgressPaymentList(Request $request)
    {
        $ids = explode(',', $request->choosen);
        $hakedis_durumu = ReturnRequest::whereIn('id', $ids)->update(['atolye_hakedis' => 2, 'faturalanma_tarihi' => date('Y-m-d')]);
    }

    public function repairProgressPaymentDownload(Request $request)
    {
        return Excel::download(new ProgressPaymentExport($request->faturalanma_tarihi), 'atolye-hakedis-listesi.xlsx');
    }

    public function changesPendingApprovalList()
    {
        $title = "Değişim Onayı Bekleyenler";
        $changes = ReturnRequest::selectRaw(
            "return_requests.id,
            return_requests.refundOrderNumber as order_number,
            return_requests.adet,
            CASE
                WHEN return_requests.consumer_id IS NOT NULL THEN CONCAT(c.firstName, ' ', c.lastName)
                ELSE CONCAT(s.name, ' ', s.musteri_kodu)
            END AS customer,
            s.id AS store_id,
            s.name AS store_name,
            'degisim_talebi' AS type,
            return_requests.created_at")
            ->leftJoin('stores AS s', 's.id', '=', 'return_requests.magaza_id')
            ->leftJoin('consumers AS c', 'c.id', '=', 'return_requests.consumer_id')
            ->where('return_requests.status', 15)
            ->get();

        return view('changes.list', compact('changes', 'title'));
    }

    public function changeDetail($id)
    {
        $title = $id . "-" . "Değişim Detayı";
        $change = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name', 'rr.name as return_reason');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->leftJoin('return_reasons as rr', 'return_request_details.sebep', '=', 'rr.id');
                    $q->where('degisim_durumu', 1);
                    $q->orderby('p.product_code', 'asc');
                },
                'consumer',
                'store'
            ]
        )->find($id);

        $log = History::with('kullanici')
            ->where('talep_id', $change->id)
            ->orderBy('id', 'desc')
            ->get();

        $say = 1;

        return view('changes.detail', compact('change', 'log', 'say', 'title'));
    }

    public function changeApprove(Request $request)
    {
        ReturnRequest::where('id', $request->return_id)->update(['status' => 16, 'kargo_no' => $request->cargo_no]);
        app('App\Http\Controllers\LogController')
            ->create('Değişim Talebi Onaylandı**'.Auth::user()->id, $request->return_id, $request->note_onay, 15, 16);

        return back()->with('msg', 'Onay İşlemi Başarıyla Gerçekleşmiştir! Değişim No:'.$request->return_id);
    }

    public function changeConvert(Request $request)
    {
        ReturnRequest::where('id', $request->return_id)->update(['tip' => 1, 'status' => 17]);
        app('App\Http\Controllers\LogController')
            ->create('Değişim, İade Talebine Dönüştürüldü**'.Auth::user()->id, $request->return_id, $request->note_onay, 15, 17);

        return back()->with('msg', 'Onay İşlemi Başarıyla Gerçekleşmiştir! Değişim No:'.$request->return_id);
    }

    public function pricingList()
    {
        $title = "Muhasebe Onayı Bekleyenler";
        $returns = ReturnRequest::selectRaw(
            "return_requests.id,
            rrt.name AS line_type,
            return_requests.refundOrderNumber as order_number,
            return_requests.status,
            return_requests.adet,
            CASE
                WHEN return_requests.consumer_id IS NOT NULL THEN CONCAT(c.firstName, ' ', c.lastName)
                ELSE CONCAT(s.name, ' ', s.musteri_kodu)
            END AS customer,
            s.id AS store_id,
            s.name AS store_name,
            'iade_talebi' AS type,
            return_requests.created_at")
            ->leftJoin('stores AS s', 's.id', '=', 'return_requests.magaza_id')
            ->leftJoin('consumers AS c', 'c.id', '=', 'return_requests.consumer_id')
            ->leftJoin('return_request_types AS rrt', 'rrt.id', '=', 'return_requests.tip')
            ->whereIn('return_requests.status', [8, 11, 17])
            ->get();

        return view('returns.pricing.list', compact('returns', 'title'));
    }

    public function pricingDetail($id)
    {
        $title = $id . "-" . "Talep Detayı";
        $tamam = false;
        $return = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_sap_code', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->where('iade_durumu', 1);
                    $q->orWhereNull('iade_durumu');
                    $q->orderby('p.product_code', 'asc');
                },
                'consumer',
                'store'
            ]
        )->find($id);

        $details = ReturnRequestDetail::where('talep_id', $id)->whereNotNull('birimfiyat')->count();
        if ($details == count($return->details)) {
            $tamam = true;
        }

        $totalPrice = ReturnRequestDetail::where('talep_id', $id)->sum('birimfiyat');

        $sap_codes = [];
        foreach ($return->details as $item) {
            $sap_codes[] = $item->product_sap_code;
        }

        $customerSalesCheck = CustomerSale::select('id', 'birim_fiyat', 'tarih', 'malzeme')
            ->whereIn('malzeme', $sap_codes)
            ->where('vkn', $return->store->vergi_no)
            ->where('fatura_tipi', '36F2')
            ->orderBy('tarih', 'desc')
            ->get();

        $customerSalesCheck = json_decode($customerSalesCheck, true);

        $log = History::with('kullanici')
            ->where('talep_id', $return->id)
            ->orderBy('id', 'desc')
            ->get();

        $say = 1;

        return view('returns.pricing.detail', compact('tamam', 'return', 'log', 'totalPrice', 'customerSalesCheck', 'say', 'title'));
    }

    public function billingInformation(Request $request)
    {
        $billing_information = CustomerSale::find($request->salesID);
        $return = ReturnRequest::find($request->returnID);
        return view('returns.pricing.modal_billing_information', compact('billing_information', 'return'));
    }

    public function pricingApproveUnitPrices(Request $request)
    {
        foreach ($request->birimfiyat as $key => $value) {
            if ($value == 0) {
                return back()->with('msg', 'Lütfen tüm fiyatları kontrol ediniz!');
            } else {
                ReturnRequestDetail::where('id', $key)->update(['birimfiyat' => ($value * 100)]);
            }
        }
        return back();
    }

    public function pricingApprove(Request $request)
    {
        $sum = ReturnRequestDetail::where('talep_id', $request->return_id)
            ->whereNotNull('birimfiyat')
            ->sum('birimfiyat');

        ReturnRequest::where('id', $request->return_id)->update(['status' => 10, 'fatura_no' => $request->invoice_no, 'fatura_tutar' => $sum]);
        app('App\Http\Controllers\LogController')
            ->create('İade Fatura Düzenleme Onayı Bekleniyor**'.Auth::user()->id, $request->return_id, $request->note_onay, 8, 10);

        return redirect()->route('returns.pricing.list')->with('msg', 'Muhasebe Onay İşlemi Başarıyla Gerçekleşmiştir! İade No:'.$request->return_id);
    }

    public function financeList()
    {
        $title = "Finans Onayı Bekleyenler";
        $returns = ReturnRequest::selectRaw(
            "return_requests.id,
            rrt.name AS line_type,
            return_requests.refundOrderNumber as order_number,
            return_requests.status,
            return_requests.adet,
            CASE
                WHEN return_requests.consumer_id IS NOT NULL THEN CONCAT(c.firstName, ' ', c.lastName)
                ELSE CONCAT(s.name, ' ', s.musteri_kodu)
            END AS customer,
            s.id AS store_id,
            s.name AS store_name,
            'iade_talebi' AS type,
            return_requests.created_at")
            ->leftJoin('stores AS s', 's.id', '=', 'return_requests.magaza_id')
            ->leftJoin('consumers AS c', 'c.id', '=', 'return_requests.consumer_id')
            ->leftJoin('return_request_types AS rrt', 'rrt.id', '=', 'return_requests.tip')
            ->where('return_requests.status', 10)
            ->get();

        return view('returns.finance.list', compact('returns', 'title'));
    }

    public function financeDetail($id)
    {
        $title = $id . "-" . "Talep Detayı";
        $return = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->where('iade_durumu', 1);
                    $q->orWhereNull('iade_durumu');
                    $q->orderby('p.product_code', 'asc');
                },
                'consumer',
                'store'
            ]
        )->find($id);

        $log = History::with('kullanici')
            ->where('talep_id', $return->id)
            ->orderBy('id', 'desc')
            ->get();

        $say = 1;

        return view('returns.finance.detail', compact('return', 'log', 'say', 'title'));
    }

    public function financeApprove(Request $request)
    {
        ReturnRequest::where('id', $request->return_id)->update(['status' => 13, 'islem_no' => $request->transaction_no]);
        app('App\Http\Controllers\LogController')
            ->create('İade Yönetici Onayı Bekleniyor**'.Auth::user()->id, $request->return_id, $request->note_onay, 10, 13);

        return redirect()->route('returns.finance.list')->with('msg', 'Finans Onay İşlemi Başarıyla Gerçekleşmiştir! İade No:'.$request->return_id);
    }

    public function adminList()
    {
        $title = "Onay Bekleyenler";
        $returns = ReturnRequest::with('store', 'user')
            ->where('status', 13)
            ->get();

        return view('returns.admin.list', compact('returns', 'title'));
    }

    public function adminDetail($id)
    {
        $title = $id . '-' . 'Talep Detayı';
        $return = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_code', 'p.product_name', 'rr.name as return_reason');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                    $q->leftJoin('return_reasons as rr', 'return_request_details.sebep', '=', 'rr.id');
                    $q->where('isOk', 0);
                    $q->orderby('p.product_code', 'asc');
                },
                'user',
                'store'
            ]
        )->find($id);

        $log = History::with('kullanici')
            ->where('talep_id', $return->id)
            ->orderBy('id', 'desc')
            ->get();

        $say = 1;
        $toplamdesi = 0;

        return view('returns.admin.detail', compact('return', 'log', 'say', 'toplamdesi', 'title'));
    }

    public function parseDistribution(Request $request)
    {
        $return = ReturnRequest::with('store')->find($request->return_id);
        return view('returns.admin.modal_parse_distribution', compact('return'));
    }

    public function adminApprove(Request $request)
    {
        $return = ReturnRequest::with('store')->find($request->return_id);
        if ($return->store->magaza_tipi == 'Own Store') {
            ReturnRequest::where('id', $request->return_id)->update(['status' => 14, 'fatura_kontrol' => 1]);
            app('App\Http\Controllers\LogController')
                ->create('İade talebi onaylandı', $request->return_id, $request->note_islem, 10, 14);
        } else {
            ReturnRequest::where('id', $request->return_id)->update(['status' => 9, 'fatura_kontrol' => -1]);
            app('App\Http\Controllers\LogController')
                ->create('İade talebi onaylandı', $request->return_id, $request->note_islem, 10, 9);
        }

        return redirect()->route('returns.admin.list')->with('msg', 'İade talebi yönetici tarafından onaylanmıştır. İade No:'.$request->return_id);
    }

    public function adminActions(Request $request)
    {
        $islem = '';

        switch ($request->islem) {
        case 'fiyatlama':
            ReturnRequest::where('id', $request->return_id)->update(['status' => 8]);
            $islem = 'Yonetici Tekrar Muhasebeye Gönderdi **'. Auth::user()->id;
            app('App\Http\Controllers\LogController')
                ->create($islem, $request->return_id, $request->note_islem, 13, 8);
            break;
        case 'atolye':
            ReturnRequest::where('id', $request->return_id)->update(['status' => 7]);
            $islem = 'Yonetici Tekrar Atölyeye Gönderdi **'. Auth::user()->id;
            app('App\Http\Controllers\LogController')
                ->create($islem, $request->return_id, $request->note_islem, 13, 8);
            break;
        default:
            ReturnRequest::where('id', $request->return_id)->update(['status' => 12]);
            $islem = 'Yönetici İadeyi Red Etti';
            app('App\Http\Controllers\LogController')
                ->create($islem, $request->return_id, $request->note_islem, 13, 12);
        }

        return redirect()->route('returns.admin.list')->with('msg', $islem.' İade No:'.$request->return_id);
    }
}
