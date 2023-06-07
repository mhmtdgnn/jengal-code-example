@extends('common.layout')
@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <!--begin::Title-->
            <div class="d-flex justify-content-between align-items-center flex-wrap py-8">
                <!--begin::store-->
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-info p-3 me-2">{{ $return->id }}</span>
                        <span class="text-gray-700 fs-2 fw-bold me-1">Mağaza ve Talep Bilgileri</span>
                    </div>
                </div>
                <!--end::store-->
            </div>
            <!--end::Title-->
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="row mb-12">
                <div class="col-lg-4">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5">
                                Mağaza
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <div class="d-block align-items-center">
                            {{ $return->store->name }} - {{ $return->store->musteri_kodu }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5">
                                Talebi Açan
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <div class="d-block align-items-center">
                            <span class="d-block">{{ $return->user->name }}</span>
                            <span class="d-block">{{ $return->user->gsm }}</span>
                            <span class="d-block">{{ $return->user->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5">
                                Tarih / Saat
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <div class="d-block align-items-center">
                            {{ $return->created_at->format('d-m-Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Details-->
            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold ps-4">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" 
                        data-bs-toggle="tab" 
                        href="#kt_tab_pane_1">
                        İade Detayı
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" 
                        data-bs-toggle="tab" 
                        href="#kt_tab_pane_2">
                        Log
                    </a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="kt_tab_pane_1" role="tabpanel">
                    <div class="table border rounded p-8">
                        <table id="kt_datatable_example_5" class="table table-striped gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                    <th>Sıra</th>
                                    <th>Talep Detay Kodu</th>
                                    <th>Ürün Kodu</th>
                                    <th>Ürün Adı</th>
                                    <th>İade Sebebi</th>
                                    <th>İade Durumu</th>
                                    <th>Ayrıştırma</th>
                                    <th>Birim Fiyat</th>
                                    <th>Fatura Edilebilir Tutar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($return->details as $item)
                                    @php
                                        switch ($item->iade_kabul_nedeni) {
                                            case 4:
                                            case 9:
                                            case 11:
                                            case 18:
                                            case 19:
                                                $kesinti = 0;
                                                $kesintiFiyat = 0;
                                                break;
                                            default:
                                                if ($item->ayristirma_id == 1) {
                                                    $kesinti = '0,00';
                                                    $kesintiFiyat = ($item->birimfiyat / 100);
                                                } else if ($item->ayristirma_id == 2) {
                                                    $kesinti = ($return->store->t2) / 100;
                                                    $kesintiFiyat = $item->birimfiyat * $kesinti;
                                                } else if ($item->ayristirma_id == 3) {
                                                    $kesinti = ($return->store->t3) / 100;
                                                    $kesintiFiyat = $item->birimfiyat * $kesinti;
                                                } else if ($item->ayristirma_id == 4) {
                                                    $kesinti = ($return->store->t4) / 100;
                                                    $kesintiFiyat = $item->birimfiyat * $kesinti;
                                                } else {
                                                    $kesinti = 1;
                                                }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $say }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->product_code }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>
                                            <span class="btn btn-sm btn-light-success fw-bold ms-2 fs-8 py-1 px-3">
                                                {{ $item->return_reason }}
                                            </span>
                                            @if(!empty($item->not))
                                            <button type="button" class="btn btn-icon btn-info ms-5" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->not }}">
                                                <!--begin::Svg Icon -->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor"/>
                                                        <rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor"/>
                                                        <rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                            @endif
                                        </td>
                                        <td>{{ config('sebportal.iade_durumu.'.$item->iade_durumu) }}</td>
                                        <td>{{ config('sebportal.ayristirma_durumu.'.$item->ayristirma_id) }}</td>
                                        <td>{{ number_format($item->birimfiyat/100, 2, ',', '.') }} ₺</td>
                                        <td>
                                            @if($item->ayristirma_id == 1)
                                                {{ @number_format($kesintiFiyat,2, ',', '.') }}
                                            @else 
                                                {{ @number_format((($item->birimfiyat/100) - (($item->birimfiyat / 100) * $kesinti)), 2, ',', '.') }}
                                            @endif
                                            ₺
                                        </td>
                                    </tr>
                                    @php $say++; @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Toplam</strong></td>
                                    <td><strong>{{ number_format($return->kesintili_fatura_tutar/100, 2, ',', '.') }} ₺</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    @if(count($return->logs) > 0)
                        @include('components.logs')
                    @else
                        <div class="border rounded p-5">
                            <span class="fs-5 text-info fw-bold me-1">Bu iadeye bağlı herhangi bir işlem gerçekleştirilmemiştir.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <span class="btn btn-md btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#modal_ayristirma_dagilim">Ayrıştırma Dağılımı</span>
            <span class="btn btn-md btn-info me-3" data-bs-toggle="modal" data-bs-target="#modal_onayla">Onayla</span>
        </div>
    </div>
</div>
<!--end::Container-->
@endsection

@section('extra_content')
    <div class="modal fade" id="modal_onayla" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('returns.product_acceptance.approve') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">Kontrol Onayı</h1>
                        </div>
                        <div class="d-flex flex-column mb-4">
                            <textarea class="form-control form-control-solid" rows="3" name="note_onay" placeholder="Onay Notu"></textarea>
                        </div>
                        <div class="mb-13">
                            <div class="text-muted fw-semibold fs-6">
                                İncelenen talepteki ürünler belirtiğiniz revizyon kodlarıyla birlikte IOM Atölyeye sevk edilecektir. Onaylıyor musunuz?
                                Devam etmeden ürünleri ve kodlarını lütfen kontrol ediniz. Uygunsuzluk veya talep ile ilgili notunuz varsa giriniz.
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="hidden" value="{{ $return->id }}" name="return_id" id="return_id">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                            <button type="submit" id="modal_onayla_submit" class="btn btn-primary">
                                <span class="indicator-label">Evet</span>
                                <span class="indicator-progress">
                                    Lütfen Bekleyiniz... 
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_ayristirma_dagilim" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <h3 class="fw-bold text-center text-gray-700 mb-12">İade Ayrıştırma Dağılımı</h3>
                    <table id="kt_datatable_example_4" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th>Ayrıştırma</th>
                                <th>Toplam Adet</th>
                                <th>Tutar</th>
                                @if($return->kesintili_fatura_tutar)
                                <th>Kesinti Tutarı</th>
                                <th>Kesintili Tutar</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($return->kesintili_fatura_tutar)
                                @foreach($returnDetails as $item)
                                    @php
                                        
                                        switch ($item->iade_kabul_nedeni) {
                                            case 4:
                                            case 9:
                                            case 11:
                                            case 18:
                                            case 19:
                                                $kesinti = 0;
                                                $kesintiFiyat = 0;
                                                break;
                                            default:
                                                if ($item->ayristirma_id == 1) {
                                                    $kesinti = '0,00';
                                                    $kesintiFiyat = ($item->fiyat / 100);
                                                } else if ($item->ayristirma_id == 2) {
                                                    $kesinti = ($return->store->t2) / 100;
                                                    $kesintiFiyat = $item->fiyat * $kesinti;
                                                } else if ($item->ayristirma_id == 3) {
                                                    $kesinti = ($return->store->t3) / 100;
                                                    $kesintiFiyat = $item->fiyat * $kesinti;
                                                } else if ($item->ayristirma_id == 4) {
                                                    $kesinti = ($return->store->t4) / 100;
                                                    $kesintiFiyat = $item->fiyat * $kesinti;
                                                } else {
                                                    $kesinti = 1;
                                                }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ config('sebportal.ayristirma_durumu.'.$item->ayristirma_id) }}</td>
                                        <td>{{ $item->adet }}</td>
                                        <td>{{ @number_format($item->fiyat/100,2, ',', '.') }} ₺</td>
                                        <td>@if($item->ayristirma_id == 1) {{ $kesinti }} @else {{ @number_format($kesintiFiyat/100,2, ',', '.') }} @endif₺</td>
                                        <td>
                                            @if($item->ayristirma_id == 1)
                                                {{ @number_format($kesintiFiyat,2, ',', '.') }}
                                            @else 
                                                {{ @number_format((($item->fiyat/100) - (($item->fiyat / 100) * $kesinti)), 2, ',', '.') }}
                                            @endif
                                            ₺
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($returnDetails as $item)
                                <tr>
                                    <td>{{ config('sebportal.ayristirma_durumu.'.$item->ayristirma_id) }}</td>
                                    <td>{{ $item->adet }}</td>
                                    <td>{{ @number_format($item->fiyat/100,2, ',', '.') }} ₺</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <!--end::Vendors Javascript-->
@endsection