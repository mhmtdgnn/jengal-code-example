@extends('common.layout')
@php
    function get_fatura_bilgisi($aranan, $sk)
    {
        $skResult = array_search($aranan, array_column($sk, 'malzeme'));
        if ($skResult === false) {
            $skResult = 'hata';
            return $skResult;
        } else {
            return $skResult;
        }
    }
@endphp
@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <!--begin::Title-->
            <div class="d-flex justify-content-between align-items-center w-100 py-6">
                <!--begin::store-->
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-info p-3 me-2">{{ $return->id }}</span>
                        <span class="text-gray-700 fs-2 fw-bold me-1">Talep Bilgileri</span>
                    </div>
                </div>
                <!--end::store-->
                <div class="d-flex">
                    @if($tamam)
                        <a href="#" class="btn btn-md btn-info me-3" data-bs-toggle="modal" data-bs-target="#modal_onayla">Kontrol Tamamlandı</a>
                    @else
                        <span class="badge badge-info-light border border-info text-info p-4 fs-6 fw-normal me-3">
                            <i class="bi bi-info-circle-fill text-info fs-4 me-3"></i>
                            Onaylamak için önce kontrolleri tamamlayınız.
                        </span>
                    @endif
                </div>
            </div>
            <!--end::Title-->
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="row mb-12">
                <div class="col-lg-6">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        @if($return->consumer_id != 0)
                            <!--begin::Underline-->
                            <span class="d-inline-block position-relative mb-4">
                                <span class="d-inline-block mb-1 fs-5">
                                    Müşteri Bilgileri
                                </span>
                                <span
                                    class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                            </span>
                            <!--end::Underline-->
                            <div class="d-block align-items-center">
                                <span class="d-block">{{ $return->consumer->firstName }} {{ $return->consumer->lastName }}</span>
                                <span class="d-block">{{ $return->consumer->email }}</span>
                                <span class="d-block">{{ $return->consumer->phone }}</span>
                            </div>
                        @else
                            <!--begin::Underline-->
                            <span class="d-inline-block position-relative mb-4">
                                <span class="d-inline-block mb-1 fs-5">
                                    Mağaza Bilgileri
                                </span>
                                <span
                                    class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                            </span>
                            <!--end::Underline-->
                            <div class="d-block align-items-center">
                                <span class="d-block">{{ $return->store->musteri_kodu.' - '.$return->store->name }}</span>
                                <span class="d-block">{{ $return->store->telefon }}</span>
                                <span class="d-block">{{ $return->store->adres }}</span>
                                <span class="d-block">{{ $return->store->il.' - '.$return->store->ilce }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <div class="row">
                            <div class="col-lg-4">
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-4">
                                    <span class="d-inline-block mb-1 fs-5">
                                        Tarih / Saat
                                    </span>
                                    <span
                                        class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <!--end::Underline-->
                                <div class="d-block align-items-center">
                                    {{ $return->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-4">
                                    <span class="d-inline-block mb-1 fs-5">
                                        Talep Tip
                                    </span>
                                    <span
                                        class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <!--end::Underline-->
                                <div class="d-block align-items-center">
                                    @if($return->tip == 1)
                                        <span class="badge badge-info p-3 me-2">İADE</span>
                                    @elseif($return->tip == 3)
                                        <span class="badge badge-info p-3 me-2">DEĞİŞİM</span>
                                    @else
                                        <span class="badge badge-info p-3 me-2">İPTAL</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                @if (isset($return->refundOrderNumber))
                                    <!--begin::Underline-->
                                    <span class="d-inline-block position-relative mb-4">
                                        <span class="d-inline-block mb-1 fs-5">
                                            Sipariş No
                                        </span>
                                        <span
                                            class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    </span>
                                    <!--end::Underline-->
                                    <div class="d-block align-items-center">
                                        {{ $return->refundOrderNumber }}
                                    </div>
                                @endif
                            </div>
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
                        @if (session('msg'))
                            <div class="alert alert-info">
                                {{ session('msg') }}
                            </div>
                        @endif
                        <form action="{{ route('returns.pricing.approve_unitprices') }}" method="post" id="birimfiyatForm">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary float-end">
                                <i class="bi bi-card-checklist fs-3 fw-bold me-2 p-0"></i>
                                TÜM SATIRLARI ONAYLA
                            </button>
                            <table id="kt_datatable_example_5" class="table table-striped gy-5 gs-7 rounded">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>Sıra</th>
                                        <th>Talep Detay Kodu</th>
                                        <th>Ürün Kodu</th>
                                        <th>Ürün Adı</th>
                                        <th>Ayrıştırma</th>
                                        <th>Birim Fiyatı</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($return->details as $item)
                                        <input type="hidden" name="return_id" id="return_id" value="{{ $item->talep_id }}">
                                        <input type="hidden" name="detail_id[]" id="detail_id" value="{{ $item->id }}">
                                        @php
                                            $time = strtotime('-1 year', time());
                                            $date = date('Y-m-d', $time);
                                            $timeMonth = strtotime('-1 month', time());
                                            $dateMonth = date('Y-m-d', $timeMonth);
                                            $birimFiyat = 0;
                                            $aranan = get_fatura_bilgisi($item->product_sap_code, $customerSalesCheck);
                                            if ($item->birimfiyat!='') {
                                                $birimFiyat = ($item->birimfiyat/100);
                                                $color = 'black';
                                            } else {
                                                if (!empty($customerSalesCheck[$aranan]['birim_fiyat']) AND $customerSalesCheck[$aranan]['tarih'] < $date) {
                                                    $birimFiyat = $customerSalesCheck[$aranan]['birim_fiyat'];
                                                    $color = '#ff7043';
                                                } elseif (!empty($customerSalesCheck[$aranan]['birim_fiyat']) AND $customerSalesCheck[$aranan]['tarih'] > $dateMonth) {
                                                    $birimFiyat = $customerSalesCheck[$aranan]['birim_fiyat'];
                                                    $color = '#ff7043';
                                                } elseif (!empty($customerSalesCheck[$aranan]['birim_fiyat'])) {
                                                    $birimFiyat = $customerSalesCheck[$aranan]['birim_fiyat'];
                                                    $color = 'black';
                                                } else {
                                                    $birimFiyat = 0;
                                                    $color = 'red';
                                                }
                                            }

                                        @endphp
                                        <tr style="color:{{ $color }}">
                                            <td>{{ $say }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td><span class="productcode_{{ $item->id }}">{{ $item->product_code }}</span></td>
                                            <td><span class="productname_{{ $item->id }}">{{ $item->product_name }}</span></td>
                                            <td>{{ config('sebportal.ayristirma_durumu.'.$item->ayristirma_id) }}</td>
                                            <td>
                                                <input type="text"
                                                    name="birimfiyat[{{ $item->id }}]"
                                                    id="birimfiyat"
                                                    value="{{ $birimFiyat }}"
                                                    onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                                    class="form-control" required>
                                            </td>
                                            <td>
                                                @if(!empty($customerSalesCheck[$aranan]))
                                                <a class="btn btn-success text-light" data-bs-toggle="modal" id="fatura_bilgileri" data-bs-target="#modal_fatura_bilgileri"
                                                    data-attr="{{ route('billingInformation') }}" data-returnID="{{ $return->id }}" data-salesID="{{ $customerSalesCheck[$aranan]['id'] }}" title="Fatura Bilgileri">
                                                    <i class="fas fa-file-invoice"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $say++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
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
        <div class="card-footer">

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
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('returns.pricing.approve') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Muhasebe Onayı</h1>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Fatura Numarası</label>
                            <input type="text" class="form-control form-control-solid" name="invoice_no" required>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Onay Notu</label>
                            <textarea class="form-control form-control-solid" rows="3" name="note_onay" placeholder=""></textarea>
                        </div>
                        <div class="mb-13 text-center">
                            <div class="text-muted fw-semibold fs-5">
                                Muhasebe onayı vermek üzeresiniz, Bu işleme devam etmek istediğinizden emin misiniz?
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
    <div class="modal fade" id="modal_fatura_bilgileri" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered mw-650px">
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
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15" id="fatura_bilgileri_body">
                    <div></div>
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
    <script>
        $(document).on('click', '#fatura_bilgileri', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            var salesID = $(this).attr('data-salesID');
            var returnID = $(this).attr('data-returnID');
            $.ajax({
                url: href,
                type: 'GET',
                data:{ salesID:salesID, returnID:returnID },
                success: function(result) {
                    $('#modal_fatura_bilgileri').modal("show");
                    $('#fatura_bilgileri_body').html(result).show();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                },
                timeout: 8000
            })
        });
    </script>
@endsection
