@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Layout-->
        <!--begin::Form-->
        <form id="kt_pickup_form">
            @csrf
            <input type="hidden" name="consumerID" required>
        <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="col-lg-8 flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body p-12">
                            <div class="mb-0">
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-6">
                                    <!--begin::Label-->
                                    <strong class="d-inline-block mb-1 fs-3 fw-bold required">
                                        TÜKETİCİ BİLGİLERİ
                                    </strong>
                                    <!--end::Label-->

                                    <!--begin::Line-->
                                    <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    <!--end::Line-->
                                </span>
                                <!--end::Underline-->
                                <!--begin::Row-->
                                <div class="row gx-10 mb-5">
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <small class="fw-bold text-gray-700">Tüketici Ara</small>
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
                                        <div class="d-flex w-100 h-150px d-none" id="consumer_profile_template">
                                            <div class="position-relative w-100 h-100 d-flex bg-light rounded border-primary border border-dashed p-6">
                                                <div class="position-absolute top-0 end-0">
                                                    <span class="btn btn-icon btn-flex btn-active-light-primary w-40px h-40px " 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#update_consumer_modal">
                                                        <i class="fas fa-pencil-alt fs-2"></i>
                                                    </span>
                                                </div>
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon |-->
                                                <span class="svg-icon svg-icon-4tx svg-icon-primary me-4">
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
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                        <div id="consumer_info_content_placeholder">
                                            <div class="h-150px bg-light d-flex flex-column justify-content-center align-items-center rounded">
                                                <i class="fas fa-user text-gray-300 fs-5tx mb-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <small class="fw-bold text-gray-700">Adres Seç</small>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <div class="row">
                                                <div class="col-10">
                                                    <select name="consumer_address" id="consumer_address" class="form-select form-select-solid">
                                                        <option value="">Önce müşteri seçiniz</option>
                                                    </select>
                                                </div>
                                                <div class="col-2" id="newConsumerAddressButton">
                                                    <button type="button" disabled="disabled"
                                                        class="btn btn-icon btn-custom btn-active-color-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#create_consumer_address_modal">
                                                        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                                                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor"/>
                                                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <div id="consumer_address_info_content_placeholder">
                                            <div class="h-150px bg-light d-flex flex-column justify-content-center align-items-center rounded">
                                                <i class="fas fa-map-marker-alt text-gray-300 fs-5tx mb-3"></i>
                                            </div>
                                        </div>
                                        <div class="position-relative h-150px w-100 d-flex bg-light rounded border-primary border border-dashed p-6 d-none" 
                                            id="consumerAddressArea">
                                            <div class="position-absolute top-0 end-0">
                                                <span class="btn btn-icon btn-flex btn-active-light-primary w-40px h-40px "
                                                    id="update_consumer_address">
                                                    <i class="fas fa-pencil-alt fs-2"></i>
                                                </span>
                                            </div>
                                            <!--begin::Icon-->
                                            <!--begin::Svg Icon |-->
                                            <span class="svg-icon svg-icon-4tx svg-icon-primary me-4">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor"/>
                                                    <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--end::Icon-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <!--begin::Content-->
                                                <div class="fw-semibold">
                                                    <div class="table-responsive">
                                                        <strong class="mb-3 d-block consumer-address-title"></strong>
                                                        <p class="mb-3 consumer-address-text"></p>
                                                        <strong class="consumer-address-city"></strong>
                                                    </div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative my-6">
                                    <!--begin::Label-->
                                    <strong class="d-inline-block mb-1 fs-3 fw-bold required">
                                        ÜRÜN BİLGİLERİ
                                    </strong>
                                    <!--end::Label-->

                                    <!--begin::Line-->
                                    <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    <!--end::Line-->
                                </span>
                                <!--end::Underline-->
                                <div class="mb-10">
                                    <div class="mb-4" data-kt-element="items">
                                        <div class="position-relative border rounded p-4 mb-3 product" data-kt-element="item">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <select class="form-select form-select-solid mb-2" name="product[row1][product_id]">
                                                        <option value="">Ürün Seçiniz</option>
                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->id }}">{{ $item->product_code }} {{ $item->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <textarea class="form-control form-control-solid mb-2" name="product[row1][complaint]" placeholder="Arıza açıklaması..."></textarea>
                                                </div>
                                                <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center">
                                                    <div class="form-check form-check-custom form-check-success form-check-solid my-3">
                                                        <input class="form-check-input" type="radio" value="1" name="product[row1][warranty]" id="warrantyTrue" required/>
                                                        <label class="form-check-label" for="warrantyTrue">
                                                            GARANTİ VAR
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-danger form-check-solid my-3">
                                                        <input class="form-check-input" type="radio" value="0" name="product[row1][warranty]" id="warrantyFalse" required/>
                                                        <label class="form-check-label" for="warrantyFalse">
                                                            GARANTİ YOK
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="position-absolute top-0 end-0">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-active-color-danger"
                                                    data-kt-element="remove-item">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <i class="far fa-trash-alt"></i>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-link py-1" data-kt-element="add-item">
                                        <i class="fas fa-plus text-primary"></i> Satır Ekle
                                    </button>
                                </div>
                                <!--begin::Notes-->
                                <div class="mb-0">
                                    <!--begin::Underline-->
                                    <span class="d-inline-block position-relative mb-6">
                                        <!--begin::Label-->
                                        <strong class="d-inline-block mb-1 fs-3 fw-bold">
                                            NOT
                                        </strong>
                                        <!--end::Label-->

                                        <!--begin::Line-->
                                        <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                        <!--end::Line-->
                                    </span>
                                    <!--end::Underline-->
                                    <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Taleple ilgili genel notlar..."></textarea>
                                </div>
                                <!--end::Notes-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-lg-auto w-lg-400px">
                    <!--begin::Card-->
                    <div class="card" 
                        {{-- data-kt-sticky="true"
                        data-kt-sticky-name="invoice"
                        data-kt-sticky-offset="{default: false, lg: '200px'}"
                        data-kt-sticky-width="{lg: '250px', lg: '400px'}" 
                        data-kt-sticky-left="auto"
                        data-kt-sticky-top="150px" 
                        data-kt-sticky-animation="false" 
                        data-kt-sticky-zindex="95" --}}
                        id="">
                        <!--begin::Card body-->
                        <div class="card-body py-10">
                            <div class="mb-12 pb-8">
                                <div class="mb-4">
                                    <div class="fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                        <!--begin::Underline-->
                                        <span class="d-inline-block position-relative mb-6">
                                            <!--begin::Label-->
                                            <strong class="d-inline-block mb-1 fs-3 fw-bold required">
                                                TALEP TİPİ
                                            </strong>
                                            <!--end::Label-->

                                            <!--begin::Line-->
                                            <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                            <!--end::Line-->
                                        </span>
                                        <!--end::Underline-->
                                        @if (Auth::user()->company_id == 8)
                                            <div class="separator separator-dashed"></div>
                                            <label class="d-flex flex-stack cursor-pointer bg-hover-light py-3 px-4">
                                                <span class="d-flex align-items-center me-2">
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="fas fa-shipping-fast text-primary fs-2x"></i>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-6">
                                                            <span class="me-3">EVDEN EVE</span>
                                                            {{-- <i class="fas fa-angle-double-left text-info fs-5"></i>
                                                            <i class="fas fa-angle-double-right text-info fs-5"></i> --}}
                                                        </span>
                                                        <span class="fs-7 text-muted">Evden Servise - Servisten Eve</span>
                                                    </span>
                                                </span>
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="request_type" value="6" checked required>
                                                </span>
                                            </label>
                                            <div class="separator separator-dashed"></div>
                                        @else
                                            <div class="separator separator-dashed"></div>
                                            <label class="d-flex flex-stack cursor-pointer bg-hover-light py-3 px-4">
                                                <span class="d-flex align-items-center me-2">
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="fas fa-shipping-fast text-primary fs-2x"></i>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-6">
                                                            <span class="me-3">EVDEN ALIM</span>
                                                            {{-- <i class="fas fa-angle-double-left text-info fs-5"></i> --}}
                                                        </span>
                                                        <span class="fs-7 text-muted">Evden Servise</span>
                                                    </span>
                                                </span>
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="request_type" value="1" required>
                                                </span>
                                            </label>
                                            <div class="separator separator-dashed"></div>
                                            <label class="d-flex flex-stack cursor-pointer bg-hover-light py-3 px-4">
                                                <span class="d-flex align-items-center me-2">
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="fas fa-shipping-fast text-primary fs-2x"></i>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-6">
                                                            <span class="me-3">EVE TESLİM</span>
                                                            {{-- <i class="fas fa-angle-double-right text-info fs-5"></i> --}}
                                                        </span>
                                                        <span class="fs-7 text-muted">Servisten Eve</span>
                                                    </span>
                                                </span>
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="request_type" value="2" required>
                                                </span>
                                            </label>
                                            <div class="separator separator-dashed"></div>
                                            <label class="d-flex flex-stack cursor-pointer bg-hover-light py-3 px-4">
                                                <span class="d-flex align-items-center me-2">
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="fas fa-shipping-fast text-primary fs-2x"></i>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-6">
                                                            <span class="me-3">EVDEN EVE</span>
                                                            {{-- <i class="fas fa-angle-double-left text-info fs-5"></i>
                                                            <i class="fas fa-angle-double-right text-info fs-5"></i> --}}
                                                        </span>
                                                        <span class="fs-7 text-muted">Evden Servise - Servisten Eve</span>
                                                    </span>
                                                </span>
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="request_type" value="6" required>
                                                </span>
                                            </label>
                                            <div class="separator separator-dashed"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mb-12 pb-8 position-relative">
                                <div class="position-absolute top-0 end-0 mt-3 pe-none text-end">
                                    {{-- <img src="{{ asset('assets/media/icons/duotune/finance/fin003.svg') }}" class="w-80px"> --}}
                                    <i class="fas fa-wallet fs-4tx text-gray-600"></i>
                                </div>
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-6">
                                    <!--begin::Label-->
                                    <strong class="d-inline-block mb-1 fs-3 fw-bold required">
                                        ÖDEME METODU
                                    </strong>
                                    <!--end::Label-->

                                    <!--begin::Line-->
                                    <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    <!--end::Line-->
                                </span>
                                <!--end::Underline-->
                                <li class="list-group-item border-0 bg-transparent">
                                    <div class="form-check form-check-custom form-check-success form-check-solid mb-3">
                                        <input class="form-check-input" name="odeyen" type="radio" value="firma_oder" id="company_pays" required/>
                                        <label class="form-check-label fw-bold" for="company_pays">
                                            FİRMA ÖDER
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-success form-check-solid">
                                        <input class="form-check-input" name="odeyen" type="radio" value="musteri_oder" id="customer_pays" required/>
                                        <label class="form-check-label fw-bold" for="customer_pays">
                                            MÜŞTERİ ÖDER
                                        </label>
                                    </div>
                                    <ul class="list-group my-2" id="musteriodersecenekleri" style="display: none;">
                                        <li class="list-group-item border-0">
                                            <div class="form-check form-check-custom form-check-warning form-check-solid">
                                                <input class="form-check-input" name="payment_type" type="radio" value="kredikarti" id="payment_card" required/>
                                                <label class="form-check-label" for="payment_card">
                                                    Kredi Kartı
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 bg-transparent">
                                            <div class="form-check form-check-custom form-check-warning form-check-solid">
                                                <input class="form-check-input" name="payment_type" type="radio" value="nakit" id="payment_cash" required/>
                                                <label class="form-check-label" for="payment_cash">
                                                    Nakit
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                            <div class="fv-row">
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-6">
                                    <!--begin::Label-->
                                    <strong class="d-inline-block mb-1 fs-3 fw-bold">
                                        YEDEK ÜRÜN
                                    </strong>
                                    <!--end::Label-->

                                    <!--begin::Line-->
                                    <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    <!--end::Line-->
                                </span>
                                <!--end::Underline-->   
                    
                                <!--begin::Input-->
                                <div class="form-check form-check-custom form-check-solid">
                                    <label role="button"
                                        class="border border-dashed border-dark rounded cursor-pointer d-flex align-items-center text-start py-2 px-6 active w-100" 
                                        data-kt-button="true">
                                        <!--begin::Radio-->
                                        <span class="form-check form-check-custom form-check-success form-check-solid form-check-sm align-items-start">
                                            <input class="form-check-input h-30px w-30px" type="checkbox" name="spare_product" value="1">
                                        </span>
                                        <!--end::Radio-->
                
                                        <!--begin::Info-->
                                        <span class="ms-5 d-flex flex-column">
                                            <span class="fs-4 fw-bold text-gray-800 d-block mb-0">YEDEK ÜRÜN HİZMETİ</span>
                                            <small class="text-gray-600 fw-normal">Yedek ürün hizmeti verilecek</small>
                                        </span>
                                        <!--end::Info-->
                                    </label>
                                </div>
                                {{-- Yalnı ARZUM kullanıcıları için gösterilecek uyarı --}}
                                @if (Auth::user()->company_id == 8) 
                                <div class="ms-2 mt-2">
                                    <small class="text-gray-700 fw-normal">
                                        <i class="fas fa-info-circle text-warning"></i> 
                                        Bu hizmet yalnızca <strong>Süpürge</strong>, <strong>Ütü</strong> ve <strong>Kahve Makinası</strong> için geçerlidir.
                                    </small>
                                </div>
                                @endif
                                <!--end::Input-->
                            </div>
                            <!--begin::Actions-->
                            <div class="mb-0 mt-12">
                                <button type="submit" href="#" class="btn btn-primary w-100"
                                    id="kt_pickup_submit_button">
                                    <span class="indicator-label">
                                        <i class="far fa-paper-plane"></i>
                                        Talebi Gönder
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
            </div>
        </form>
        <!--end::Form-->
        <!--end::Layout-->
    </div>
    <!--end::Container-->

@endsection

@section('extra_content')
    <div id="components" class="d-none">
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
        <!--end::Spinner template-->
    </div>

    <div id="js_template" class="d-none">
        <table class="home-service-item">
            <div class="position-relative border rounded p-4 mb-3 product" data-kt-element="item">
                <div class="row">
                    <div class="col-lg-9">
                        <select class="form-select form-select-solid mb-2" name="product[0][product_id]">
                            <option value="">Ürün Seçiniz</option>
                            @foreach ($products as $item)
                                <option value="{{ $item->id }}">{{ $item->product_code }} {{ $item->product_name }}</option>
                            @endforeach
                        </select>
                        <textarea class="form-control form-control-solid mb-2" name="product[0][complaint]" placeholder="Arıza açıklaması..."></textarea>
                    </div>
                    <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center">
                        <div class="form-check form-check-custom form-check-success form-check-solid my-3">
                            <input class="form-check-input" type="radio" value="1" name="product[0][warranty]" id="[0]_warrantyTrue" required/>
                            <label class="form-check-label" for="[0]_warrantyTrue">
                                GARANTİ VAR
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-danger form-check-solid my-3">
                            <input class="form-check-input" type="radio" value="0" name="product[0][warranty]" id="[0]_warrantyFalse" required/>
                            <label class="form-check-label" for="[0]_warrantyFalse">
                                GARANTİ YOK
                            </label>
                        </div>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0">
                    <button type="button"
                        class="btn btn-sm btn-icon btn-active-color-danger"
                        data-kt-element="remove-item">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                        <i class="far fa-trash-alt"></i>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
        </table>
    </div>
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
                @csrf
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

    <!-- begin::Modal - Müşteri Adresi Ekle -->
    <div id="create_consumer_address_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <form id="add_consumer_address_form" class="px-lg-8">
                @csrf
                <input type="hidden" name="consumerID" value="[[consumerID]]">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-map-marked-alt fs-1 text-info me-4"></i> Müşteri Adresi Ekle</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                        <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                    </g>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Adres Adı <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Adres Adı (Ev, İş, vb)" name="address_name" id="address_name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Adres <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <textarea type="text" class="form-control"  placeholder="Açık Adres" name="address" id="address"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">İl <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <select name="address_city" id="address_city" required class="form-control">
                                        <option value="">İl Seçiniz</option>
                                        <option value="34">İstanbul</option>
                                        {{-- @foreach($cities as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">İlçe <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <select name="address_town" id="address_town" required class="form-control">
                                        <option value="">Önce İl Seçiniz</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-primary" id="add_consumer_address_form_button" data-consumer-id="">
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
    <!-- end::Modal - Müşteri Adresi Ekle -->

    <!--begin::Consumer Address Update Modal-->
    <div class="modal fade" tabindex="-1" id="update_consumer_address_modal">
        <div class="modal-dialog">
            <form id="update_consumer_address_form" class="px-lg-8">
                @csrf
                <input type="hidden" name="addressID">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Müşteri Adresi Bilgilerini Güncelle</h3>
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
                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Adres Adı <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Adres Adı (Ev, İş, vb)" name="address_name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Adres <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <textarea type="text" class="form-control"  placeholder="Açık Adres" name="address"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">İl <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <select name="address_city" id="address_city" required class="form-control">
                                        <option>İl Seçiniz</option>
                                        @foreach($cities as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">İlçe <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <select name="address_town" id="address_town" required class="form-control">
                                        <option value="">Önce İl Seçiniz</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-primary" id="update_consumer_address_form_button" data-adress-id="" data-consumer-id="">
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

@section('footer_scripts')
    <script>
        $(document).ready(function () {
            localStorage.clear();
        });

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

        // input Mask
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
            allowClear: true,
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
            var newRow= $('#js_template div[data-kt-element="item"]').eq(0).clone();
            newRow.html(function(i, oldHTML) {
                return oldHTML.replaceAll('[0]', '[' + token + ']');
            });
            $('div[data-kt-element="items"]').append(newRow);
            $('.product select').select2({
                minimumInputLength: 2,
                placeholder: 'Seçiniz',
                language: { inputTooShort: function () { return "Lütfen en az 2 karakter giriniz.."; } }
            });
        });

        /**
         * Satır Sil
        */
        $(document).on('click', 'button[data-kt-element="remove-item"]', function () {
            $(this).closest('div[data-kt-element="item"]').remove();
        });

        // $(document).on('click', 'button[data-kt-element="remove-item"]', function () {
        //     $(this).parent('tr[data-kt-element="item"]').remove();
        // });

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
                        $('#newConsumerAddressButton button').removeAttr('disabled');
                        fillConsumerInfo(response);
                        getConsumerAddresses(consumerID);
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

            $('#consumer_info_content_placeholder').addClass('d-none');
            $('#consumer_profile_template').removeClass('d-none');
        }

        // Müşteri Adres Bilgileri Çek - AJAX
        function getConsumerAddresses(consumerID) {
            $.ajax({
                type: "POST",
                url: "{{ route('consumer.getConsumerAddress') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    consumer_id: consumerID
                },
                success: function (response) {
                    console.log(response);
                    if (response.addresses.length > 0) {
                        fillConsumerAddresses(response);
                    } else {
                        newConsumerAddressForm();
                    }
                }
            });
        }

        // Müşteri Bilgilerini Doldur
        function fillConsumerAddresses(data) {
            let html = '<option value="">Adres seçiniz</option>';
            $.map(data.addresses, function (item, key) {
                html += `<option value="${item.id}" data-title="${item.address_name}" data-text="${item.address}" data-city="${item.city}" data-town="${item.town}">${item.address_name} - ${item.address} ${item.town}/${item.city}</option>`;
            });
            $('#consumer_address').html(html);
        }

        $(document).on('change', 'select[name="consumer_address"]', function () {
            $('#consumer_address_info_content_placeholder').addClass('d-none');
            $('#consumerAddressArea').removeClass('d-none');
            let title = $(this).find(':selected').data('title');
            let text = $(this).find(':selected').data('text');
            let city = $(this).find(':selected').data('city');
            let town = $(this).find(':selected').data('town');

            $('.consumer-address-title').text(title);
            $('.consumer-address-text').text(text);
            $('.consumer-address-city').text(town+'/'+city);
        });

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

        // Müşteri Adresi Bilgileri Güncelle
        function newConsumerAddressForm() {
            $('#create_consumer_address_modal').modal('show');
        }

        // Yeni Müşteri Adresi Ekle
        $(document).on('click', '#add_consumer_address_form_button', function () {
            let form = $('#add_consumer_address_form');
            let formData = form.serializeArray();
            button = $(this);
            button.attr("data-kt-indicator", "on");
            let consumerID = button.data('consumer-id');

            form.validate({
                errorPlacement: function(){
                    return false;
                },
            })

            if (form.valid()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('consumer.createConsumerAddress') }}",
                    data: formData,
                    success: function (response) {
                        if (response) {
                            console.log(response);
                            button.removeAttr("data-kt-indicator");
                            $('#create_consumer_address_modal').modal('hide');
                            toastr.success('Tebrikler! Müşteri adres kaydı eklendi.');
                            form.trigger("reset");
                            getConsumerAddresses(consumerID);
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

        // Müşteri Adresi Bilgilerini Güncelle
        $(document).on('click', '#update_consumer_address', function () {
            let selectedAddress = $('#consumer_address').val();

            if (selectedAddress > 0) {
                $('#update_consumer_address_form input[name="addressID"]').val('');
                $('#update_consumer_address_form input[name="address_name"]').val('');
                $('#update_consumer_address_form textarea[name="address"]').text('');
                $('#update_consumer_address_form select[name="address_city"]').val('');
                $('#update_consumer_address_form select[name="address_town"]').val('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('consumer.getSelectedAddress') }}",
                    data: {_token: "{{ csrf_token() }}", addressID: selectedAddress},
                    success: function (response) {
                        if (response) {
                            $('#update_consumer_address_form input[name="addressID"]').val(response.id);
                            $('#update_consumer_address_form input[name="address_name"]').val(response.address_name);
                            $('#update_consumer_address_form textarea[name="address"]').text(response.address);
                            $('#update_consumer_address_form select[name="address_city"]').val(response.city).change();
                            getTowns(response.city, '#update_consumer_address_form select[name="address_town"]', response.town);
                            $('#update_consumer_address_form_button').data('address-id', response.id);
                            $('#update_consumer_address_form_button').data('consumer-id', response.consumer_id);
                        }
                    }
                }).done(function(){
                    $('#update_consumer_address_modal').modal('toggle');
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Güncelleme için geçerli bir adres seçimi yapmadınız.',
                    position: 'center'
                });
            }
        });

        //Müşteri Adresi Güncelle
        $(document).on('click', '#update_consumer_address_form_button', function () {
            let form = $('#update_consumer_address_form');
            let formData = form.serializeArray();
            button = $(this);
            button.attr("data-kt-indicator", "on");
            let consumerID = button.data('consumer-id');
            let addressID = button.data('address-id');

            form.validate({
                errorPlacement: function(){
                    return false;
                },
            });
            if (form.valid()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('consumer.updateConsumerAddress') }}",
                    data: formData,
                    success: function (response) {
                        if(response) {
                            button.removeAttr("data-kt-indicator");
                            $('#update_consumer_address_modal').modal('hide');
                            toastr.success('Tebrikler! Müşteri adres kaydı güncellenmiştir.');
                            form.trigger("reset");
                            getConsumerAddresses(consumerID);
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

        //Yeni Müşteri Adresi Ekle Formu - İlçeler
        $(document).on('change', '#address_city', (arguments) => {
            let city = $('#address_city').val();
            getTowns(city, '#address_town');
        });

        //Müşteri Adresi Güncelle Formu - İlçeler
        $(document).on('change', '#update_consumer_address_form select[name="address_city"]', (arguments) => {
            let city = $('#update_consumer_address_form select[name="address_city"]').val();
            getTowns(city, '#update_consumer_address_form select[name="address_town"]');
        });

        //AJAX  İlçeler
        function getTowns(city, resultDiv, selected) { 
            $.ajax({
                type: "post",
                url: "{{ route('towns') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'city_id': city
                },
                success: function (response) {
                    if (response) {
                        let html = '<option value="">Seçiniz</value>';
                        response.map((item) => {
                            html += `<option value="${item.id}" ${ item.id == selected ? 'selected' : '' }>${item.name}</option>`;
                        })
                        $(resultDiv).html(html);
                    }
                }
            });
        }

        $('input[name="odeyen"]').on('change', function () {
            if ($(this).val() == 'musteri_oder') {
                $('#musteriodersecenekleri').show();
            } else {
                $('#musteriodersecenekleri').hide();
            }
        });

        // Form Kaydet - AJAX
        $(document).on('click', '#kt_pickup_submit_button', function () {
            let form = $('#kt_pickup_form');
            let formData = form.serializeArray();
            button = $(this);
            button.attr("disabled", "disabled");
            button.attr("data-kt-indicator", "on");

            form.validate({
                errorPlacement: function(){
                    return false;
                },
            });

            formData.push({name: 'request_type', value: $('input[name="request_type"]:checked').val()});
            formData.push({name: 'odeyen', value: $('input[name="odeyen"]:checked').val()});
            formData.push({name: 'payment_type', value: $('input[name="payment_type"]:checked').val()});
            formData.push({name: 'spare_product', value: $('input[name="spare_product"]:checked').val()});

            if (form.valid()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('bicozumExpress.storePickupRequest') }}",
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        if (response) {
                            // button.removeAttr("disabled");
                            // button.removeAttr("data-kt-indicator");
                            toastr.success('Tebrikler! Müşteri kaydı eklendi.');
                            window.location.href= "{{ route('bicozumExpress.myPickupRequests') }}";
                        }
                    },
                    error: function () {
                        toastr.error('HATA! Bir sorun oluştu.');
                    }
                });
            } else {
                button.removeAttr('disabled');
                button.removeAttr('data-kt-indicator');
                toastr.error('Lütfen tüm alanları eksiksiz doldurun.');
            }
        });
    </script>
@endsection
