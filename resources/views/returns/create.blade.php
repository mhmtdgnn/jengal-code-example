@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body p-12">
                        <!--begin::Form-->
                        <form action="{{ route('returns.save') }}" id="kt_invoice_form" method="POST">
                            @csrf
                            <input type="hidden" name="consumerID">
                            <!--begin::Wrapper-->
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>Ürün Ekle</h3>
                                    <span>İade etmek istediğini ürünleri listeye ekleyin.</span>
                                </div>
                                <div class="col-lg-6 text-center text-lg-end">
                                    <button type="button" class="btn btn-sm btn-light-primary border border-primary" data-bs-toggle="modal" data-bs-target="#modal_import">
                                        <i class="fas fa-file-import"></i> Excel ile yükle
                                    </button>
                                </div>
                            </div>
                            <!--end::Top-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mt-5 mb-10"></div>
                            <!--end::Separator-->
                            <!--begin::Wrapper-->
                            <div class="mb-0">
                                <!--begin::Table wrapper-->
                                <div class="table-responsive mb-10">
                                    <!--begin::Table-->
                                    <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                <th class="w-20px">
                                                    <img src="{{ asset('assets/media/icons/duotune/general/gen024.svg') }}"/>
                                                </th>
                                                <th class="min-w-300px w-475px">Ürün</th>
                                                <th class="min-w-100px w-100px">Adet</th>
                                                <th class="min-w-150px w-150px">İade Nedeni</th>
                                                <th class="min-w-100px w-250px">Açıklama (Opsiyonel)</th>
                                                <th class="min-w-75px w-75px text-end">Satır Sil</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                <td>
                                                    <img src="{{ asset('assets/media/icons/duotune/coding/cod007.svg') }}"/>
                                                </td>
                                                <td class="pe-7 product">
                                                    <select class="form-select form-select-solid mb-2" name="product[row1][product_code]">
                                                        <option></option>
                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->product_code }}">{{ $item->product_code }} {{ $item->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="ps-0">
                                                    <input class="form-control form-control-solid" type="number" min="1" name="product[row1][quantity]" placeholder="0" value="1" data-kt-element="quantity" />
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-solid mb-2" name="product[row1][reason]">
                                                        <option value="">Seçiniz</option>
                                                        @foreach ($reasons as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid border" name="product[row1][description]" data-kt-element="description" />
                                                </td>
                                                <td class="pt-5 text-end">
                                                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                        <!--begin::Table foot-->
                                        <tfoot>
                                            <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                <th class="text-primary">
                                                    <img src="{{ asset('assets/media/icons/duotune/abstract/abs011.svg') }}"/>
                                                </th>
                                                <th>
                                                    <button type="button" class="btn btn-link py-1" data-kt-element="add-item" id="add-item">Yeni Satır</button>
                                                </th>
                                            </tr>
                                        </tfoot>
                                        <!--end::Table foot-->
                                    </table>
                                </div>
                                <!--end::Table-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-10"></div>
                                <!--end::Separator-->
                                <div class="d-flex flex-column align-items-center justify-content-center flex-xxl-row">
                                    <div class="@if(Auth::user()->company_id == 1) col-md-4 @else col-md-8 @endif px-5">
                                        <div class="form-group">
                                            <textarea 
                                                class="form-control form-control-solid" 
                                                rows="7" 
                                                name="note_onay"
                                                placeholder="Talep ile ilgili ek bir notunuz varsa burada belirtebilirsiniz.(Opsiyonel)"></textarea>
                                        </div>
                                    </div>
                                    @if(Auth::user()->company_id == 1)
                                    <div class="col-md-4 px-5">
                                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Müşteri Bilgisi</label>
                                        <!--begin::Input group-->
                                        <div class="position-relative mb-5">
                                            <input type="text"id="called-phone" 
                                                class="form-control form-control-solid"
                                                placeholder="(___) ___-____" />
                                            <button
                                                type="button" 
                                                id="search-consumer"
                                                class="btn btn-light btn-sm text-primary border border-primary p-3 rounded-circle position-absolute top-50 start-100 translate-middle">
                                                <span class="indicator-label">
                                                    BUL
                                                </span>
                                                <span class="indicator-progress">
                                                    <span class="spinner-border spinner-border-sm align-middle m-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="d-flex w-100 h-150px mb-3 d-none" id="consumer_profile_template">
                                            <div
                                                class="notice w-100 h-100 d-flex bg-light-info rounded border-info border border-dashed mb-9 p-6">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon |-->
                                                <span class="svg-icon svg-icon-4tx svg-icon-info me-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
                                                            fill="currentColor" />
                                                        <rect opacity="0.3" x="8" y="3" width="8"
                                                            height="8" rx="4" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="consumer-profile d-flex flex-stack flex-grow-1">
                                                    <!--begin::Content-->
                                                    <div class="fw-semibold">
                                                        <div class="table-responsive">
                                                            <table class="table table-row-dashed table-row-gray-300 gy-1">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>İsim</td>
                                                                        <td>
                                                                            <span class="consumer-name"></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Telefon</td>
                                                                        <td>
                                                                            <span class="consumer-phone"></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>
                                                                            <span class="consumer-email"></span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!--end::Content-->
                                                    <span class="btn btn-icon btn-flex btn-active-light-primary w-40px h-40px " 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#update_consumer_modal">
                                                        <i class="fas fa-pencil-alt fs-2"></i>
                                                    </span>
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                        <!--begin::Spinner template-->
                                        <div id="spinner_tamplate" class="d-none">
                                            <div class="spinner-wrapper text-center pt-20 t-15">
                                                <div class="spinner-grow text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-secondary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-success" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-warning" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-info" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Spinner template-->
                                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Mağaza</label>
                                        <select class="form-select form-select-solid mb-2" name="store_id" required>
                                            <option value="">Seçiniz</option>
                                            @foreach ($stores as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="col-md-4 px-5">
                                        @if(Auth::user()->company_id == 1)
                                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Sipariş Numarası</label>
                                        <div class="form-group w-250px">
                                            <input type="text" class="form-control form-control-solid mb-3" placeholder="Sipariş Numarası" name="orderId">
                                        </div>
                                        @endif
                                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Koli</label>
                                        <div class="form-group w-250px">
                                            <input type="number" class="form-control form-control-solid mb-3" placeholder="Koli adedi" name="koli">
                                        </div>
                                        <button type="submit" href="#" class="btn btn-info w-250px" id="kt_invoice_submit_button">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="currentColor" />
                                                    <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->Talebi Gönder
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wrapper-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Container-->
    <!--begin::Item template-->
    <table class="table d-none" data-kt-element="item-template">
        <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
            <td>
                <img src="{{ asset('assets/media/icons/duotune/coding/cod007.svg') }}"/>
            </td>
            <td class="pe-7 product">
                <select class="form-select form-select-solid mb-2" name="product[0][product_code]">
                    <option></option>
                    @foreach ($products as $item)
                        <option value="{{ $item->product_code }}">{{ $item->product_code }} {{ $item->product_name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="ps-0">
                <input class="form-control form-control-solid" type="number" min="1" name="product[0][quantity]" placeholder="0" value="1" data-kt-element="quantity" />
            </td>
            <td>
                <select class="form-select form-select-solid mb-2" name="product[0][reason]">
                    <option value="">Seçiniz</option>
                    @foreach ($reasons as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="form-control form-control-solid border" name="product[0][description]" data-kt-element="description" />
            </td>
            <td class="pt-5 text-end">
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
            </td>
        </tr>
    </table>
    <table class="table d-none" data-kt-element="empty-template">
        <tr data-kt-element="empty">
            <th colspan="5" class="text-muted text-center py-10">No items</th>
        </tr>
    </table>
    <!--end::Item template-->
    <!-- begin:Modal Excel Import -->
    <div class="modal fade" tabindex="-1" id="modal_import">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('returns.save') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h3>Excel ile Talep Yükle</h3>
                    </div>
                    <div class="modal-body">
                        <div id="upload">
                            <p class="mb-8">Örnek Excel şablonu için <a href="/sample/ornek_talep.xlsx" target="_self">tıklayınız</a></p>
                            @csrf
                            <label for="myfile">Dosya Seçiniz</label>
                            <input type="file" id="myfile" class="form-control" name="myfile">
                        </div>
                    </div>
                    <div class="modal-footer py-3">
                        <input type="submit" name="import" id="import" value="Yükle" class="btn btn-success btn-xs">
                        <div id="loader" style="display: none">
                            <center>
                                <img src="{{ asset('img/loading.gif') }}" />
                                <h4>Lütfen Bekleyiniz, Yükleme İşlemi Yapılıyor...</h4>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end:Modal Excel Import -->
    @section('extra_content')
        <!--begin::Consumer Drawer-->
        <div 
            id="consumer_drawer" 
            class="bg-white"
            data-kt-drawer="true"
            data-kt-drawer-activate="true"
            data-kt-drawer-toggle="#consumer_drawer_button"
            data-kt-drawer-close="#consumer_drawer_close"
            data-kt-drawer-width="400px">
            <!--begin::Card-->
            <div class="card w-100 rounded-0">
                <!--begin::Card header-->
                <div class="card-header pe-5">
                    <!--begin::Title-->
                    <div class="card-title">
                        <!--begin::User-->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <span class="text-muted searched-text"></span>
                            <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Arama Sonuçları</a>
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-light-primary" id="consumer_drawer_close">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div 
                    {{-- style="background: url('https://img.icons8.com/officel/344/search--v1.png') no-repeat center center / contain" --}}
                    class="card-body position-relative hover-scroll-overlay-y">
                    <div id="consumers-list"></div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Consumer Drawer-->

        <!--begin::Consumer Card Template-->
        <div id="consumer-item-template" class="d-none">
            <div class="consumer-item bg-white">
                <div class="d-flex flex-stack">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-40px me-4">
                        <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">[[symbol]]</div>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                        <!--begin:Author-->
                        <div class="flex-grow-1 me-2">
                            <span class="text-gray-800 text-hover-primary fs-6 fw-bold">[[name]]</span>
                            {{-- <span class="text-muted fw-semibold d-block fs-7">[[phone]]</span> --}}
                            <span class="text-muted fw-semibold d-block fs-7">[[email]]</span>
                        </div>
                        <!--end:Author-->
                        <button type="button" class="btn btn-secondary btn-sm consumer-select-button" data-consumer-id="[[consumerID]]">SEÇ</button>
                    </div>
                    <!--end::Section-->
                </div>
                <div class="separator separator-dashed my-4"></div>
            </div>
        </div>
        <!--end::Consumer Card Template-->

        <!--begin::Consumer Seearch Result toolbar-->
        <div class="engage-toolbar d-flex position-fixed px-5 fw-bold zindex-2 top-50 end-0 transform-90 mt-5 mt-lg-20 gap-2">
            <!--begin::Help drawer toggle-->
            <button 
                id="consumer_drawer_button" 
                class="engage-help-toggle btn engage-btn shadow-sm px-5 rounded-top-0" 
                title="Arama Sonuçları" 
                data-bs-toggle="tooltip" 
                data-bs-placement="left" 
                data-bs-dismiss="click" 
                data-bs-trigger="hover">
                Arama Sonuçları
            </button>
            <!--end::Help drawer toggle-->
        </div>
        <!--end::Consumer Seearch Result toolbar-->

        <!--begin::Consumer Add Modal-->
        <div class="modal fade" tabindex="-1" id="add_consumer_modal">
            <div class="modal-dialog modal-dialog-centered">
                <form id="add_consumer_form" class="px-lg-8">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Yeni Müşteri Kayıt</h3>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                    </svg>
                                </span>
                            </div>
                            <!--end::Close-->
                        </div>
                        <div class="modal-body">
                            <div class="px-lg-8">
                                <label class="text-gray-600" for="">Ad Soyad <span class="required"></span></label>
                                <div class="input-group mb-5">
                                    <input type="text" name="firstName" class="form-control form-control-solid me-2" placeholder="İsim" required/>
                                    <input type="text" name="lastName" class="form-control form-control-solid ms-2" placeholder="Soyisim" required/>
                                </div>
                                <div class="mb-5">
                                    <label class="text-gray-600" for="add_consumer_phone">Telefon <span class="required"></span></label>
                                    <input type="text" 
                                        name="phone"
                                        class="form-control form-control-solid" 
                                        id="add_consumer_phone" 
                                        placeholder="(___) ___-____" 
                                        readonly required/>
                                </div>
                                <div class="mb-5">
                                    <label class="text-gray-600" for="add_consumer_email">Email</label>
                                    <input type="email" 
                                        name="email"
                                        class="form-control form-control-solid"
                                        id="add_consumer_email"
                                        placeholder="name@example.com"/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                            <button type="button" class="btn btn-primary" id="add_consumer_form_button">
                                <span class="indicator-label">
                                    KAYDET
                                </span>
                                <span class="indicator-progress">
                                    Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Consumer Add Modal-->

        <!--begin::Consumer Update Modal-->
        <div class="modal fade" tabindex="-1" id="update_consumer_modal">
            <div class="modal-dialog modal-dialog-centered">
                <form id="update_consumer_form" class="px-lg-8">
                    @csrf>
                    <input type="hidden" name="consumerID" value="[[consumerID]]">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Müşteri Bilgileri Güncelle</h3>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                    </svg>
                                </span>
                            </div>
                            <!--end::Close-->
                        </div>
                        <div class="modal-body">
                            <div class="px-lg-8">
                                <label class="text-gray-600" for="">Ad Soyad <span class="required"></span></label>
                                <div class="input-group mb-5">
                                    <input 
                                        type="text" 
                                        name="firstName" 
                                        class="form-control form-control-solid me-2" 
                                        placeholder="İsim" 
                                        required/>
                                    <input 
                                        type="text" 
                                        name="lastName" 
                                        class="form-control form-control-solid ms-2" 
                                        placeholder="Soyisim" 
                                        required/>
                                </div>
                                <div class="mb-5">
                                    <label class="text-gray-600" for="update_consumer_phone">Telefon <span class="required"></span></label>
                                    <input type="text" 
                                        name="phone"
                                        class="form-control form-control-solid"
                                        id="update_consumer_phone"
                                        placeholder="(___) ___-____"
                                        readonly required/>
                                </div>
                                <div class="mb-5">
                                    <label class="text-gray-600" for="update_consumer_email">Email</label>
                                    <input type="email" 
                                        name="email"
                                        class="form-control form-control-solid" 
                                        id="update_consumer_email"
                                        value="[[consumermail]]"
                                        placeholder="name@example.com"
                                        autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                            <button type="button" class="btn btn-primary" id="update_consumer_form_button" data-consumer-id="">
                                <span class="indicator-label">
                                    GÜNCELLE
                                </span>
                                <span class="indicator-progress">
                                    Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Consumer Update Modal-->
    @endsection
@endsection

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <script>
        /**
        * Genel Fonksiyon ve Ayarlar
        */
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Inputmask({
            "mask" : "(999) 999-9999",
            "placeholder": "(___) ___-____",
        }).mask("#called-phone");

        Inputmask({
            "mask" : "(999) 999-9999",
            "placeholder": "(___) ___-____",
        }).mask("#add_consumer_phone");

        $('.product select').select2({
            minimumInputLength: 2,
            placeholder: 'Seçiniz',
            language: { inputTooShort: function () { return "Lütfen en az 2 karakter giriniz.."; } }
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        /**
         * Random id
        */
        function generate_token(length){
            //edit the token allowed characters
            var a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".split("");
            var b = [];  
            for (var i=0; i<length; i++) {
                var j = (Math.random() * (a.length-1)).toFixed(0);
                b[i] = a[j];
            }
            return b.join("");
        }

        /**
         * Yeni satır ekle
        */
        $('button[data-kt-element="add-item"]').on('click', function () {
            $('.product select').select2('destroy');
            let token = generate_token(4);
            var newRow= $('table[data-kt-element="item-template"] tr').eq(0).clone();
            newRow.html(function(i, oldHTML) {
                return oldHTML.replaceAll('[0]', '[' + token + ']');
            });
            $('table[data-kt-element="items"] tbody').append(newRow);
            $('.product select').select2( { minimumInputLength: 2,
                placeholder: 'Seçiniz',
                language: { inputTooShort: function () { return "Lütfen en az 2 karakter giriniz.."; } }
            });
        });

        /**
         * Satır Sil
        */
        $(document).on('click', 'button[data-kt-element="remove-item"]', function () {
            $(this).closest('tr[data-kt-element="item"]').remove();
        });

        // Numaradan tüketici/müşteri bul
        $('#called-phone').keypress(function (e) { 
            if(e.keyCode == 13)
            {
                $('#search-consumer').trigger('click');
            }
        });

        $('#search-consumer').on('click', function () {
            let phone = $('#called-phone').val();
            let button = $(this);
            var drawerEl = document.querySelector("#consumer_drawer");
            var drawer = KTDrawer.getInstance(drawerEl);
            button.attr("data-kt-indicator", "on");
            button.addClass('disabled');

            $('#consumers-list').html('');
            $('#consumer_drawer .searched-text').text(phone);

            $.ajax({
                type: "POST",
                url: "{{ route('consumer.consumerSearch') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    phone: phone
                },
                success: function (response) {
                    if (response.length > 0) {
                        $.each(response, function (index, item) { 
                            let template = $('#consumer-item-template .consumer-item').clone();

                            template.html(function(i, oldHTML) {
                                return oldHTML.replaceAll('[[name]]', item.firstName + ' ' + item.lastName)
                                    .replaceAll('[[phone]]', item.phone)
                                    .replaceAll('[[email]]', item.email)
                                    .replaceAll('[[consumerID]]', item.id)
                                    .replaceAll('[[symbol]]', item.firstName.slice(0,1));
                            });

                            $('#consumers-list').append(template);
                        });
                        drawer.show();
                    } else {
                        Toast.fire({
                            icon: 'info',
                            title: 'Eşleşen sonuç bulunamadı.'
                        });
                        newConsumerForm();
                    }
                    button.removeAttr("data-kt-indicator");
                    button.removeClass('disabled');
                }
            });
        });

        // Müşteri Seç
        $(document).on('click', '.consumer-select-button', function () {
            var drawerEl = document.querySelector("#consumer_drawer");
            var drawer = KTDrawer.getInstance(drawerEl);
            let selectedConsumerID = $(this).data('consumer-id');
            toastr.success('Kullanıcı Seçildi' + ' ' + selectedConsumerID);
            drawer.hide();
            getConsumerInfo(selectedConsumerID);
        });

        // Müşteri Bilgileri Çek - AJAX
        function getConsumerInfo(consumerID) {
            $('#spinner_tamplate').removeClass('d-none');

            $.ajax({
                type: "POST",
                url: "{{ route('consumer.getConsumerInfo') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    consumer_id: consumerID
                },
                success: function (response) {
                    if (response) {
                        localStorage.setItem('selected-consumer-info', JSON.stringify(response.consumer));
                        $('#spinner_tamplate').addClass('d-none');
                        $('#newConsumerAddressButton').removeClass('d-none');
                        fillConsumerInfo(response);
                    }
                }
            });
        }

        // Müşteri Bilgilerini Doldur
        function fillConsumerInfo(data) {
            $('.consumer-name').text(data.consumer.firstName + ' ' + data.consumer.lastName);
            $('.consumer-phone').text(data.consumer.phone);
            $('.consumer-email').text((data.consumer.email == null) ? '' : data.consumer.email);
            $('input[name="firstName"]').val(data.consumer.firstName);
            $('input[name="lastName"]').val(data.consumer.lastName);
            $('input[name="phone"]').val(data.consumer.phone);
            $('input[name="email"]').val((data.consumer.email == null) ? '' : data.consumer.email);
            $('input[name="consumerID"]').val(data.consumer.id);
            $('#update_consumer_form_button').data('consumer-id', data.consumer.id); 
            $('#add_consumer_address_form_button').data('consumer-id', data.consumer.id); 

            $('#consumer_profile_template').removeClass('d-none');
        }

        // Yeni Müşteri Modal Open
        $('#new-consumer').on('click', function () {
            newConsumerForm();
        });

        //Yeni Müşteri Fonksiyonu
        function newConsumerForm() {
            let calledPhone = $('#called-phone').val().replace(/[^0-9\.]/g, '');

            if (calledPhone.length < 10) {
                Toast.fire({
                    icon: 'error',
                    title: 'Numara alanı boş bırakılamaz.',
                    position: 'center'
                });
            } else {
                $('#add_consumer_modal').modal('show');
                $('#add_consumer_form #add_consumer_phone').val(calledPhone);
            }
        }

        // Yeni Müşteri Ekle
        $(document).on('click', '#add_consumer_form_button', function () {
            let form = $('#add_consumer_form');
            let formData = form.serializeArray();
            button = $(this);
            button.attr("data-kt-indicator", "on");

            form.validate({
                errorPlacement: function(){
                    return false;
                },
            })

            if (form.valid()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('consumer.createConsumer') }}",
                    data: formData,
                    success: function (response) {
                        if (response) {
                            console.log(response);
                            button.removeAttr("data-kt-indicator");
                            $('#add_consumer_modal').modal('hide');
                            toastr.success('Tebrikler! Müşteri kaydı eklendi.');
                            form.trigger("reset");
                            getConsumerInfo(response.id);
                        }
                    }
                });
            } else {
                button.removeAttr('data-kt-indicator');
                Toast.fire({
                    icon: 'error',
                    title: 'Lütfen tüm alanları eksiksiz doldurun.',
                    position: 'center'
                });
            }
        });

        // Müşteri Bilgileri Güncelle
        $(document).on('click', '#update_consumer_form_button', function () {
            let button = $(this);
            let form = $('#update_consumer_form');
            let formData = form.serializeArray();
            let consumerID = button.data('consumer-id');

            button.attr("data-kt-indicator", "on");

            form.validate({
                errorPlacement: function(){
                    return false;
                },
            });
            if (form.valid()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('consumer.updateConsumer') }}",
                    data: formData,
                    success: function (response) {
                        if (response) {
                            button.removeAttr("data-kt-indicator");
                            $('#update_consumer_modal').modal('hide');
                            getConsumerInfo(consumerID);
                        }
                    }
                });
            } else {
                button.removeAttr('data-kt-indicator');
                Toast.fire({
                    icon: 'error',
                    title: 'Lütfen tüm alanları eksiksiz doldurun.',
                    position: 'center'
                });
            }
        });

        $(document).ready(function(){
            $("#upload").on("submit", function(){
                $("#loader").fadeIn();
                $("#upload").fadeOut();
            });//submit
        });
    </script>
    
@endsection