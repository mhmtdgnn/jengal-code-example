@php
    $time = strtotime('-1 year', time());
    $date = date('Y-m-d', $time);
    $iade_oran = 0;
    $onaylanirsa_iade_oran = 0;
    $kesinti = 0;
    $kesintiFiyat = 0;
    $text = '';
    $icon = '';
    $fark = 0;

    $ayristirma = \App\Models\ReturnRequestDetail::select('ayristirma_id', 'iade_kabul_nedeni', DB::raw('count(*) as adet'), DB::raw('sum(birimfiyat) as fiyat'), DB::raw('sum(iscilik_ucreti) as iscilik'))->where('talep_id', $return->id)->where('isOk', 0)->groupby('ayristirma_id', 'iade_kabul_nedeni')->get();
    $toplam_adet = \App\Models\ReturnRequestDetail::where('talep_id', $return->id)->where('isOk', 0)->count();
    $toplam_sku = \App\Models\ReturnRequestDetail::select('product_sap_code')->where('talep_id', $return->id)->where('isOk', 0)->groupby('product_sap_code')->get();
    $toplam_satis = \App\Models\CustomerSale::where('vkn', $return->store->vergi_no)->where('tarih', '>', $date)->where('fatura_tipi', '36F2')->sum('sales');
    $toplam_sap = \App\Models\CustomerSale::where('vkn', $return->store->vergi_no)->where('tarih', '>', $date)->where('fatura_tipi', '36RE')->sum('sales');
    $toplam_iade_fatura = \App\Models\ReturnRequest::leftJoin('stores', 'return_requests.magaza_id', '=', 'stores.id')
        ->where('stores.vergi_no', $return->store->vergi_no)
        ->where('return_requests.created_at', '>', $date)
        ->whereIn('return_requests.status', [9,13,14,16,17,171,172])->sum('fatura_tutar');
    if ($toplam_satis != '' and $toplam_satis != 0) {
        $iade_oran = number_format((($toplam_iade_fatura/100)/$toplam_satis)*100, 2, ',', '.');
        $onaylanirsa_iade_oran = number_format(((($toplam_iade_fatura/100) + ($talep->kesintili_fatura_tutar/100)) / $toplam_satis)*100, 2, ',', '.');
        if ($onaylanirsa_iade_oran > $iade_oran) {
            $text = 'success';
            $icon = 'fas fa-angle-double-up';
        } elseif ($onaylanirsa_iade_oran == $iade_oran) {
            $text = '';
            $icon = '';
        } else{
            $text = 'danger';
            $icon = 'fas fa-angle-double-down';
        }
        $fark = (intval(str_replace(',', '', $onaylanirsa_iade_oran)) - intval(str_replace(',', '', $iade_oran)))/100;
    } else {
        $iade_oran = 0;
        $onaylanirsa_iade_oran = 0;
    }

@endphp

<div class="row">
    <div class="col-md-12">
        <!-- Input group addons -->
        <div class="card mb-5">
            <div class="card-body">
                <span class="d-inline-block position-relative mb-6">
                    <span class="d-inline-block mb-2 fs-3 fw-bold">
                        Talep Ayrıştırma Dağılımı
                    </span>
                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-warning translate rounded"></span>
                </span>
                <table class="table table-row-dashed table-row-gray-300 gy-3">
                    <thead>
                        <tr>
                            <th>Ayrıştırma</th>
                            <th>Toplam Adet</th>
                            <th>Fiyat</th>
                            @if($return->kesintili_fatura_tutar)
                            <th>Kesinti Tutarı</th>
                            <th>Kesintili Tutaar</th>
                            @endif
                            <th>Toplam İşçilik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($return->kesintili_fatura_tutar)
                            @foreach($ayristirma as $ay)
                                @php
                                    switch ($ay->iade_kabul_nedeni) {
                                        case 4:
                                        case 9:
                                        case 11:
                                        case 18:
                                        case 19:
                                            $kesinti = 0;
                                            $kesintiFiyat = 0;
                                            break;
                                        default:
                                            // kesinti olduktan sonra iade fiyatı
                                            if ($ay->ayristirma_id == 1) {
                                                $kesinti = '0,00';
                                                $kesintiFiyat = ($ay->fiyat / 100);
                                            } else if ($ay->ayristirma_id == 2) {
                                                $kesinti = ($return->store->t2) / 100;
                                                $kesintiFiyat = $ay->fiyat * $kesinti;
                                            } else if ($ay->ayristirma_id == 3) {
                                                $kesinti = ($return->store->t3) / 100;
                                                $kesintiFiyat = $ay->fiyat * $kesinti;
                                            } else if ($ay->ayristirma_id == 4) {
                                                $kesinti = ($return->store->t4) / 100;
                                                $kesintiFiyat = $ay->fiyat * $kesinti;
                                            } else {
                                                $kesinti = 1;
                                            }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ config('sebportal.ayristirma_durumu.'.$ay->ayristirma_id) }}</td>
                                    <td>{{ $ay->adet }}</td>
                                    <td>{{ @number_format($ay->fiyat/100,2, ',', '.') }} ₺</td>
                                    <td>@if($ay->ayristirma_id == 1) {{ $kesinti }} @else {{ @number_format($kesintiFiyat/100,2, ',', '.') }} @endif₺</td>
                                    <td>
                                        @if($ay->ayristirma_id == 1)
                                            {{ @number_format($kesintiFiyat,2, ',', '.') }}
                                        @else 
                                            {{ @number_format((($ay->fiyat/100) - (($ay->fiyat / 100) * $kesinti)), 2, ',', '.') }}
                                        @endif
                                        ₺
                                    </td>
                                    <td>{{ @number_format($ay->iscilik/100,2, ',', '.') }} ₺</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($ayristirma as $ay)
                            <tr>
                                <td>{{ config('sebportal.ayristirma_durumu.'.$ay->ayristirma_id) }}</td>
                                <td>{{ $ay->adet }}</td>
                                <td>{{ @number_format($ay->fiyat/100,2, ',', '.') }} ₺</td>
                                <td>{{ @number_format($ay->iscilik/100,2, ',', '.') }} ₺</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Input group addons -->
        <div class="card">
            <div class="card-header align-items-center">
                <span class="fw-bolder text-gray-700">Talep Adet Dağılımları</span>
            </div>
            <div class="card-body">
                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-2">
                    <tbody class="fw-semibold text-gray-600">
                        <tr>
                            <td>Toplam Ürün Adeti :</td>
                            <td class="text-end">{{ $toplam_adet }}</td>
                        </tr>
                        @php
                            $i = 0;
                            foreach($toplam_sku as $sku){
                                $i++;
                            }
                        @endphp
                        <tr>
                            <td>Toplam Satış :</td>
                            <td class="text-end">{{ $i }}</td>
                        </tr>
                        <tr>
                            <td>Toplam Desi :</td>
                            <td class="text-end">{{ $return->total_desi }}</td>
                        </tr>
                        <tr>
                            <td>Toplam Navlun Bedeli :</td>
                            <td class="text-end">{{ @number_format($return->navlun/100,2, ',', '.') }}₺</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Input group addons -->
        <div class="card">
            <div class="card-header align-items-center">
                <span class="fw-bolder text-gray-700">Talep İade ve Satış Dağılımları (Onaylanmazsa)</span>
            </div>
            <div class="card-body">
                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-2">
                    <tbody class="fw-semibold text-gray-600">
                        <tr>
                            <td>Toplam Satış :</td>
                            <td class="text-end">{{ number_format($toplam_satis, 2, ',', '.') }}₺</td>
                        </tr>
                        <tr>
                            <td>Toplam SAP İade :</td>
                            <td class="text-end">{{ number_format(abs($toplam_sap), 2, ',', '.') }}₺</td>
                        </tr>
                        <tr>
                            <td>Toplam İade Fatura Tutarı :</td>
                            <td class="text-end">{{ number_format(($toplam_iade_fatura/100), 2, ',', '.') }}₺</td>
                        </tr>
                        <tr>
                            <td>İade Oranı :</td>
                            <td class="text-end">%{{ $iade_oran }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Input group addons -->
        <div class="card">
            <div class="card-header align-items-center justify-content-between">
                <span class="col-10 fw-bolder text-gray-700">Talep İade ve Satış Dağılımları (Onaylanırsa)</span>
                <span class="col-2 float-end text-{{ $text }}"><i class="{{ $icon }} text-{{ $text }} mr-2"></i> %{{ $fark }}</span>
            </div>
            <div class="card-body">
                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-2">
                    <tbody class="fw-semibold text-gray-600">
                        <tr>
                            <td>Toplam Satış :</td>
                            <td class="text-end">{{ number_format($toplam_satis, 2, ',', '.') }}₺</td>
                        </tr>
                        <tr>
                            <td>Toplam SAP İade :</td>
                            <td class="text-end">{{ number_format(abs($toplam_sap), 2, ',', '.') }}₺</td>
                        </tr>
                        <tr>
                            <td>Toplam İade Fatura Tutarı :</td>
                            <td class="text-end">{{ number_format((($toplam_iade_fatura/100) + ($return->kesintili_fatura_tutar/100)), 2, ',', '.') }}₺</td>
                        </tr>
                        <tr>
                            <td>İade Oranı :</td>
                            <td class="text-end">%{{ $onaylanirsa_iade_oran }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>