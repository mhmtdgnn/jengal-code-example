@extends('common.layout')
@php
    function getProduct($id) {

        $a =  @App\Models\Product::select('product_name')->where('id', $id)->first();
        return @$a->product_name;
    }
@endphp
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
                                    <th>Red Sebebi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($return->details as $item)
                                    <tr>
                                        <td>{{ $say }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->product_code }}</div></td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ config('sebportal.ayristirma_durumu.'.$item->ayristirma_id) }}</td>
                                    </tr>
                                    @php $say++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    @if(count($return->logs)>0)
                        @include('components.logs')
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            @if($return->sevk_evrak == 1)
                <a href="#" class="btn btn-md btn-success me-3" data-bs-toggle="modal" data-bs-target="#modal_onayla" id="step2">
                    Onayla
                </a>
            @else
                <a href="#" target="_blank" 
                    class="btn btn-md btn-success me-3" 
                    id="step1" 
                    onclick="dispatchPrint('printableArea', {{ $return->id }})">
                    Sevk Formu Oluştur
                </a>
            @endif
        </div>
    </div>
    <!--end::Navbar-->
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
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('returns.product_acceptance.approve_dispatch') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">Mağazaya Sevk Onayı</h1>
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row">
                            <select class="form-select form-select-solid" 
                                data-control="select2" 
                                data-hide-search="true" 
                                data-placeholder="Transfer Yöntemi Seçiniz"
                                 name="transfer" required>
                                <option value="">Transfer Yöntemi Seçiniz...</option>
                                @foreach ($transfer as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-13">
                            <div class="text-muted fw-semibold fs-6">
                                <p class="mb-1">Listede belirtilen ürünler Yönetici veya IOM Atölye tarafından red edilmiş ürünlerdir.</p>
                                <p class="mb-1">Devam etmeden önce gelen ürün sayısı, Ürün kodlarını kontrol ediniz.</p>
                                <p class="mb-1">Devam etmek istiyor musunuz?</p>
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
    <div id="printableArea" style="display: none">
        <div class="row">
            <div class="col-md-12">
                <h2 style="text-align: left">TALEP: {{ $return->id }}</h2>
                <h4 style="text-align: center">Mağazaya Taşıma Formu</h4>
                <div class="row">
                    <div class="col-md-12">
                        <span>Tarih : {{ date('d.m.Y') }}</span><br>
                    </div>
                    <div class="col-md-12">
                        <p>Mağaza : {{ $return->store->name }}</p>
                        <hr>
                        <table class="table">
                            <thead>
                                <th>Sıra</th>
                                <th>SKU</th>
                                <th>Ürün Adı</th>
                                <th>Arıza Notu</th>
                            </thead>
                            <tbody>
                            @foreach($return->details as $item)
                                <tr>
                                    <td>{{ $printSay }}</td>
                                    <td>{{ $item->product_code }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->ariza }}</td>
                                </tr>item
                                @php $printSay++; @endphp
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                    </div>
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
        function dispatchPrint(divName, id) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

            $.ajax({
                type: "GET",
                url: "{{ route('dispatchPrint') }}",
                data: { 
                    id: id
                },
                success: function () {
                }
            });
        }
    </script>
@endsection