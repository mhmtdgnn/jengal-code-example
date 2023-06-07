@extends('common.layout')
@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <!--begin::Title-->
            <div class="d-flex justify-content-between align-items-center w-100 py-8">
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
                                    <th>Ürün SAP Kodu</th>
                                    <th>Ürün Adı</th>
                                    <th>İade Sebebi</th>
                                    <th>Ayrıştırma</th>
                                    <th>Fiyat</th>
                                    <th>Desi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($return->details as $item)
                                    <tr>
                                        <td>{{ $say }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td><div class="productcode_{{ $item->id }}">{{ $item->product_code }}</div></td>
                                        <td><div class="productname_{{ $item->id }}">{{ $item->product_name }}</div></td>
                                        <td>
                                            <span class="badge badge-info fw-bold fs-8 py-1 px-3">
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
                                        <td><small>{{ config('sebportal.ayristirma_durumu.'.$item->ayristirma_id) }}</small></td>
                                        <td>{{ @number_format($item->birimfiyat/100,2, ',', '.') }}₺</td>
                                        <td>{{ $item->desi }}</td>
                                    </tr>
                                    @php $toplamdesi = $toplamdesi + $item->desi; $say++; @endphp
                                @endforeach
                            </tbody>
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
        <div class="card-footer d-flex">
            <div class="d-flex justify-content-center mb-4 w-50">
                <div class="bg-light-info border border-dashed border-info p-6 rounded">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-2 w-400px">
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <!--begin::Invoice-->
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-truck fs-5 text-dark me-3"></i>
                                        Toplam Desi
                                   </div>
                                </td>
                                <td class="fw-bold text-end">
                                    <span class="text-gray-600 text-hover-primary">{{ $return->total_desi }}</span>
                                </td>
                            </tr>
                            <!--end::Invoice-->
                            <!--begin::Shipping-->
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-puzzle fs-5 text-dark me-3"></i>
                                        Toplam Adet 
                                   </div>
                                </td>
                                <td class="fw-bold text-end">
                                    <span class="text-gray-600 text-hover-primary">{{ $return->adet }}</span>
                                </td>
                            </tr>
                            <!--end::Shipping-->
                            <!--begin::Rewards-->
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-cash fs-5 text-dark me-3"></i>
                                        Toplam Tutuar <small class="ms-2"> (KDV Hariç)</small> 
                                    </div>
                                </td>
                                <td class="fw-bold text-end">
                                    <span class="fs-5">
                                        @if(!empty($return->kesintili_fatura_tutar))
                                            <strong>{{ number_format($return->kesintili_fatura_tutar/100,2, ',', '.') }}₺ </strong>
                                        @else
                                            <strong>{{ number_format($return->fatura_tutar/100,2, ',', '.') }}₺ </strong>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <!--end::Rewards-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center mb-4 w-50">
                <span class="btn btn-md btn-light-primary me-3" 
                    data-bs-toggle="modal" id="ayristirmaDagilim" 
                    data-bs-target="#modal_ayristirma_dagilim"
                    data-attr="{{ route('parseDistribution') }}"
                    data-return="{{ $return->id }}">
                    Ayrıştırma Dağılımı
                </span>
                <span class="btn btn-md btn-info me-3" data-bs-toggle="modal" data-bs-target="#modal_onayla">Onayla</span>
                <span class="btn btn-md btn-danger" data-bs-toggle="modal" data-bs-target="#modal_reddet">Reddet</span>
            </div>
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
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('returns.admin.approve') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">İade Onayı</h1>
                        </div>
                        <div class="d-flex flex-column mb-5">
                            <textarea class="form-control form-control-solid" rows="4" name="note_onay" placeholder="Onay Notu"></textarea>
                        </div>
                        <div class="mb-13">
                            <div class="text-muted fw-semibold fs-5">
                                İadeyi onaylıyorsunuz. Bu işleme devam etmek istediğinizden emin misiniz?
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
    <div class="modal fade" id="modal_reddet" tabindex="-1">
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
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('returns.admin.actions') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">İade Red - Revizyon İşlemi</h1>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <textarea class="form-control form-control-solid" rows="4" name="note_islem" placeholder="İşlem Notu"></textarea>
                        </div>
                        <div class="mb-13">
                            <div class="text-muted fw-semibold fs-5">
                                <h4>Buton Tanımları</h4>
                                <ul>
                                    <li class="mb-3 fs-6">
                                        Ürün fiyatlarında bir problem olduğunu düşünüyorsanız <b>FİYATLAMAYA REVİZYONA GÖNDER</b>
                                    </li>
                                    <li class="mb-3 fs-6">
                                        Ürün ayrıştırma veya ürün kodlarında bir problem olduğunu düşünüyorsanız <b>ATÖLYEYE REVİZYONA GÖNDER</b>
                                    </li>
                                    <li class="mb-3 fs-6">
                                        Talebin iptal edilip iade işlemi olmadan ürünlerin mağazaya geri gönderilmesini istiyorsanız <b>REDDET</b>   
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="hidden" value="{{ $return->id }}" name="return_id" id="return_id">
                            <button type="submit" class="btn btn-light-danger" name="islem" value="red">İadeyi Reddet</button>
                            <button type="submit" class="btn btn-info" name="islem" value="fiyatlama">Fiyatlamaya Gönder</button>
                            <button type="submit" class="btn btn-primary" name="islem" value="tamir">Tamire Gönder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_ayristirma_dagilim" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded" style="background-color: #f1f4f7">
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
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15" id="ayristirma_dagilim_body">
                    <div id="ajaxSpinner" class="text-center hidden">
                        <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                        <br>
                        Lütfen Bekleyiniz...
                    </div>
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
        $(document).on('click', '#ayristirmaDagilim', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            var return_id = $(this).attr('data-return');
            $.ajax({
                url: href,
                type: 'GET',
                data:{
                    return_id:return_id 
                },
                beforeSend: function () {
                    $('#ajaxSpinner').removeClass('hidden')
                },
                success: function(result) {
                    $('#modal_ayristirma_dagilim').modal("show");
                    $('#ayristirma_dagilim_body').html(result).show();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                },
                complete: function () {
                    $('#ajaxSpinner').addClass('hidden')
                }
            })
        });
    </script>
@endsection