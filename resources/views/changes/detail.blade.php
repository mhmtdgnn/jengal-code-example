@extends('common.layout')
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
                        <span class="badge badge-info p-3 me-2">{{ $change->id }}</span>
                        <span class="text-gray-700 fs-2 fw-bold me-1">Talep Bilgileri</span>
                    </div>
                </div>
                <!--end::store-->
                <div class="d-flex">
                    <a href="#" class="btn btn-md btn-info me-3" data-bs-toggle="modal" data-bs-target="#modal_onayla">Onayla</a>
                    <a href="#" class="btn btn-md btn-primary me-3" data-bs-toggle="modal" data-bs-target="#modal_convert">İadeye Dönüştür</a>
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
                        @if($change->consumer_id != 0)
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
                                <span class="d-block">{{ $change->consumer->firstName }} {{ $change->consumer->lastName }}</span>
                                <span class="d-block">{{ $change->consumer->email }}</span>
                                <span class="d-block">{{ $change->consumer->phone }}</span>
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
                                <span class="d-block">{{ $change->store->musteri_kodu.' - '.$change->store->name }}</span>
                                <span class="d-block">{{ $change->store->telefon }}</span>
                                <span class="d-block">{{ $change->store->adres }}</span>
                                <span class="d-block">{{ $change->store->il.' - '.$change->store->ilce }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <div class="row">
                            <div class="col-lg-6">
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
                                    {{ $change->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                @if (isset($change->refundOrderNumber))
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
                                        {{ $change->refundOrderNumber }}
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
                        Değişim Detayı
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
                                    <th>TDID</th>
                                    <th>Ürün Kodu</th>
                                    <th>Ürün Adı</th>
                                    <th>İade Sebebi</th>
                                    <th>Arıza Notu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($change->details as $item)
                                    <tr>
                                        <td>{{ $say }}</td>
                                        <td>
                                            <small class="text-primary">{{ $item->id }}</small>
                                        </td>
                                        <td>
                                            <small class="productcode_{{ $item->id }}">{{ $item->product_code }}</small>
                                        </td>
                                        <td>
                                            <small class="productname_{{ $item->id }}">{{ $item->product_name }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">
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
                                        <td>{{ $item->ariza }}</td>
                                    </tr>
                                    @php $say++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    @if(count($change->logs) > 0)
                        @include('components.logs')
                    @else
                        <div class="border rounded p-5">
                            <span class="fs-5 text-info fw-bold me-1">Bu değişime bağlı herhangi bir işlem gerçekleştirilmemiştir.</span>
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
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('changes.approve') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Kargo Numarası</label>
                            <input type="text" class="form-control form-control-solid" name="cargo_no" required>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Onay Notu</label>
                            <textarea class="form-control form-control-solid" rows="3" name="note_onay" placeholder=""></textarea>
                        </div>
                        <div class="mb-13 text-center">
                            <div class="text-muted fw-semibold fs-5">
                                Değişim onayı vermek üzeresiniz, Bu işleme devam etmek istediğinizden emin misiniz?
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="hidden" value="{{ $change->id }}" name="return_id" id="return_id">
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
    <div class="modal fade" id="modal_convert" tabindex="-1">
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
                    <form id="modal_convert_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('changes.convert') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Onay Notu</label>
                            <textarea class="form-control form-control-solid" rows="3" name="note_onay" placeholder=""></textarea>
                        </div>
                        <div class="mb-13 text-center">
                            <div class="text-muted fw-semibold fs-5">
                                Değişim talebini iade talebine çevirmek üzeresiniz, Bu işleme devam etmek istediğinizden emin misiniz?
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="hidden" value="{{ $change->id }}" name="return_id" id="return_id">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                            <button type="submit" id="modal_convert_submit" class="btn btn-primary">
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
@endsection

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <!--end::Vendors Javascript-->
@endsection
