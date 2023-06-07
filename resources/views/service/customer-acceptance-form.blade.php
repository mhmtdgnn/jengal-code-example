@extends('common.layout')
@section('head')
    <link
        rel="stylesheet"
        type="text/css"
        href="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.css"/>
@endsection
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
                        <!--begin::Stepper-->
                        <div class="stepper stepper-pills" id="kt_stepper_example_basic">
                            <!--begin::Nav-->
                            <div class="stepper-nav flex-center flex-wrap border-bottom py-5 mb-10">
                                <div class="stepper-item mx-2 my-4 current" data-kt-stepper-element="nav">
                                    <div class="stepper-line w-40px"></div>
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Müşteri
                                        </h3>

                                        <div class="stepper-desc">
                                            Müşteri Seç
                                        </div>
                                    </div>
                                </div>
                                <div class="stepper-item mx-2 my-4" data-kt-stepper-element="nav">
                                    <div class="stepper-line w-40px"></div>
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Ürün
                                        </h3>

                                        <div class="stepper-desc">
                                            Ürün Seç
                                        </div>
                                    </div>
                                </div>
                                <div class="stepper-item mx-2 my-4" data-kt-stepper-element="nav">
                                    <div class="stepper-line w-40px"></div>
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">3</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Detay
                                        </h3>

                                        <div class="stepper-desc">
                                            Arıza Detayları
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Nav-->
                            <!--begin::Form-->
                            <form class="form mx-auto"
                                action="{{ route('service.createClaim') }}"
                                method="POST"
                                enctype="multipart/form-data"
                                novalidate="novalidate"
                                id="kt_stepper_example_basic_form">
                                @csrf
                                <!--begin::Group-->
                                <div class="mb-5">
                                    <!--begin::Step 1-->
                                    <div class="flex-column current" style="min-height: 400px" data-kt-stepper-element="content">
                                        <input type="hidden" name="consumerFirstName" id="consumerFirstName">
                                        <input type="hidden" name="consumerLastName" id="consumerLastName">
                                        <input type="hidden" name="consumerMobilePhone" id="consumerMobilePhone">
                                        <input type="hidden" name="consumerID" id="consumerID">
                                        <div class="row mt-5 consumerSearchSection">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-10">
                                                            <label for="searchConsumerMobilePhone"
                                                                class="form-label">Telefon</label>
                                                            <input type="tel" class="form-control form-control-solid"
                                                                id="searchConsumerMobilePhone" placeholder="(XXX) XXX XXXX" data-mask="(999) 999-9999"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-10">
                                                        <label for="searchConsumerName" class="form-label">İsim</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            id="searchConsumerName" placeholder="İsim" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div
                                                            class="alert bg-light-primary p-3 d-flex flex-column align-items-center border border-primary flex-sm-row">
                                                            <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                                    viewBox="0 0 24 24" version="1.1">
                                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                                                    <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
                                                                    <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
                                                                </svg>
                                                            </span>
                                                            <div class="d-flex flex-column align-content-center">
                                                                <h4 class="mb-1 text-primary">Arama Seçenekleri</h4>
                                                                <small>
                                                                    <ul>
                                                                        <li>İsim ile arama yapmak için isim ve soyisim alanlarının
                                                                            birlikte doldurulması gerekir.</li>
                                                                        <li>İsim ve soyisim kullanmadan sadece telefon numarası ile de arama yapılabilir.</li>
                                                                        <li>Tüm bilgileri doldurarak tam eşleşme sağalanabilir.</li>
                                                                        <li>Arama sonucunda girilen kriterler ile tüketici bulunamaz ise "Yeni Müşteri Ekle"
                                                                            butonu ile kayıt eklenebilir.</li>
                                                                    </ul>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-end">
                                                        <button type="button" class="btn btn-primary" id="consumerSearch">
                                                            <span class="indicator-label">
                                                                Müşteri Ara
                                                            </span>
                                                            <span class="indicator-progress">
                                                                Lütfen bekleyin... <span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="consumerSearchResults">
                                                <div class="d-flex justify-content-center align-items-center h-100">
                                                    <div class="text-center px-4 searched-product-placeholder">
                                                        <img class="mw-100 mh-200px" alt="" src="{{ asset('/assets/media/illustrations/sigma-1/15.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center" id="consumerLoading" style="min-height: 400px; display: none;">
                                            <div class="spinner-grow text-primary mx-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-primary mx-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-primary mx-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-primary mx-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-primary mx-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 mb-5 mb-xl-8" id="customerInfo" style="display: none;">
                                                <div class="card card-dashed border-info shadow-none">
                                                    <div class="card-body pt-10">
                                                        <div class="notice d-flex p-3">
                                                            <div class="d-flex flex-center">
                                                                <div class="symbol symbol-75px symbol-circle me-5 mb-3">
                                                                    <span
                                                                        class="symbol-label bg-light-success text-success border border-success fw-bold"
                                                                        id="slicedName" style="font-size: 2.7rem;"></span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <strong
                                                                        class="fs-3 text-gray-800 text-uppercase text-hover-primary fw-bolder mb-1"
                                                                        id="consumerNameInfo"></strong>
                                                                    <span class="fs-5 fw-bold text-muted mb-3"
                                                                        id="consumerPhoneInfo"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-between">
                                                        <button type="button"
                                                            class="btn btn-light-info border border-info border-dotted consumer-services-button">
                                                            <span class="indicator-label">
                                                                Servis Kayıtları
                                                            </span>
                                                            <span class="indicator-progress">
                                                                Lütfen bekleyin... <span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                            </span>
                                                        </button>

                                                        <button type="button"
                                                            class="btn btn-light-primary border border-primary border-dotted consumer-services-button disabled">
                                                            <span class="indicator-label">
                                                                Faturalar
                                                            </span>
                                                            <span class="indicator-progress">
                                                                Lütfen bekleyin... <span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 mb-5 mb-xl-8" id="deliveredInfo" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header align-items-center mt-0" style="min-height: 20px;">
                                                        <h3 class="card-title text-center w-100 d-block">
                                                            <span class="fw-bolder mb-2 text-dark text-uppercase">
                                                                Teslim Eden Bilgisi
                                                            </span>
                                                        </h3>
                                                    </div>
                                                    <div class="card-body pt-10">
                                                        <div class="row mb-3" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                                                            <div class="col-6 mb-5">
                                                                <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex flex-column text-start p-6 active"
                                                                    data-kt-button="true">
                                                                    <span class="d-flex mb-2">
                                                                        <span class="form-check form-check-custom form-check-solid form-check-sm me-5">
                                                                            <input class="form-check-input" type="radio" name="teslim-eden" value="1" checked="checked">
                                                                        </span>
                                                                        <span class="fs-4 fw-bolder">Ürünün Sahibi</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div class="col-6 mb-5">
                                                                <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex flex-column text-start p-6"
                                                                    data-kt-button="true">
                                                                    <span class="d-flex mb-2">
                                                                        <span class="form-check form-check-custom form-check-solid form-check-sm me-5">
                                                                            <input class="form-check-input" type="radio" name="teslim-eden" value="2">
                                                                        </span>
                                                                        <span class="fs-4 fw-bolder">Kargo</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div class="col-6 mb-5">
                                                                <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex flex-column text-start p-6"
                                                                    data-kt-button="true">
                                                                    <span class="d-flex mb-2">
                                                                        <span class="form-check form-check-custom form-check-solid form-check-sm me-5">
                                                                            <input class="form-check-input" type="radio" name="teslim-eden" value="3">
                                                                        </span>
                                                                        <span class="fs-4 fw-bolder">Müşteri Adresinden Alınacak</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div class="col-6 mb-5">
                                                                <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex flex-column text-start p-6"
                                                                    data-kt-button="true">
                                                                    <span class="d-flex mb-2">
                                                                        <span class="form-check form-check-custom form-check-solid form-check-sm me-5">
                                                                            <input class="form-check-input" type="radio" name="teslim-eden" value="9">
                                                                        </span>
                                                                        <span class="fs-4 fw-bolder">Diğer</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            {{-- begin::Kargo Bilgileri --}}
                                                            <div class="col-12 card card-dashed py-7" id="shipping-section" style="display: none;">
                                                                <h3 class="text-center d-block mb-5 pb-5 border-bottom">Kargo Bilgisi Giriniz</h3>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">Gönderen Ad
                                                                        Soyad</label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <input type="text" name="gonderen_ad_soyad"
                                                                                id="gonderen_ad_soyad" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">Gönderen
                                                                        Telefon</label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <input type="text" name="gonderen_telefon"
                                                                                id="gonderen_telefon" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">Kargo
                                                                        Şirketi</label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <select name="kargo_sirketi" id="kargo_sirketi"
                                                                                class="form-control">
                                                                                <option>Kargo Şirketi Seçiniz</option>
                                                                                <option value="aras_kargo">Aras Kargo</option>
                                                                                <option value="surat_kargo">Sürat Kargo</option>
                                                                                <option value="yurtici_kargo">Yurtiçi Kargo
                                                                                </option>
                                                                                <option value="ptt_kargo">PTT Kargo</option>
                                                                                <option value="diger">Diğer</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">Kargo Takip
                                                                        No</label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <input type="text" name="kargo_takip_no"
                                                                                id="kargo_takip_no" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">Kargo Teslim
                                                                        Tarihi</label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <input class="form-control kargo_teslim_tarihi"
                                                                                id="kargo_teslim_tarihi" inputmode="text"
                                                                                name="kargo_teslim_tarihi">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">Mağaza Adı</label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <select id="magaza_adi" data-control="select2"
                                                                                data-placeholder="Mağaza Seçiniz"
                                                                                name="musteri_kodu" class="form-control">
                                                                                <option></option>
                                                                                @foreach ($stores as $item)
                                                                                    <option value="{{ $item->musteri_kodu }}">
                                                                                        {{ $item->musteri_kodu }}
                                                                                        {{ $item->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">Mağaza Takip
                                                                        Kodu</label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <input type="text" name="magaza_takip_kodu"
                                                                                id="magaza_takip_kodu" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- end::Kargo Bilgileri --}}
                                                            {{-- begin::Müşteri Adresinden Alınacak --}}
                                                            <div class="col-12 card card-dashed py-7" id="consumer-address" style="display: none">
                                                                <h3 class="text-center d-block mb-5 pb-5 border-bottom">Adres Bilgisi Giriniz</h3>
                                                                <div class="form-group mb-5">
                                                                    <label>Müşteri Adresi</label>
                                                                    <select id="consumerAddress" name="consumerAddress" class="form-control select-search"></select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button
                                                                        type="button"
                                                                        id="newConsumerAddress"
                                                                        class="btn btn-info btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#create_consumer_address_modal">
                                                                        Yeni Adres Ekle
                                                                    </button>
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-primary btn-sm"
                                                                        id="updateConsumerAddress">
                                                                        Seçili Adresi Güncelle
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            {{-- end::Müşteri Adresinden Alınacak --}}

                                                            {{-- begin::Diğer Teslim Eden Bilgisi --}}
                                                            <div class="col-12 card card-dashed py-7" id="consignor" style="display: none;">
                                                                <h3 class="text-center d-block mb-5 pb-5 border-bottom">
                                                                    Gönderen Bilgisi Giriniz
                                                                </h3>
                                                                <div class="form-group row mb-5">
                                                                    <label class="col-form-label col-lg-3">
                                                                        Gönderen Ad Soyad
                                                                    </label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <input type="text" name="diger_ad_soyad" id="diger_ad_soyad" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-form-label col-lg-3">
                                                                        Gönderen Telefon
                                                                    </label>
                                                                    <div class="col-lg-9">
                                                                        <div class="input-group">
                                                                            <input type="text" name="diger_telefon" id="diger_telefon" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- end::Diğer Teslim Eden Bilgisi --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Step 1-->

                                    <!--begin::Step 2-->
                                    <div class="flex-column" style="min-height: 400px" data-kt-stepper-element="content">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <input type="hidden" name="product_name" id="product_name">
                                        <input type="hidden" name="product_code" id="product_code">
                                        <input type="hidden" name="iris_kategori" id="iris_kategori">
                                        <div id="kt_content_container" class="container">
                                            <!--begin::Card-->
                                            <div class="card shadow-none border">
                                                <!--begin::Card body-->
                                                <div class="card-body p-0">
                                                    <!--begin::Wrapper-->
                                                    <div class="card-px text-center py-2 my-6">
                                                        <h2 class="fs-2x fw-bolder mb-5">Ürün Ekle!</h2>
                                                        <p class="text-gray-400 fs-4 fw-bold mb-10">Ürün adı veya model numarası ile arama yapabilirsiniz</p>
                                                        <div class="row">
                                                            <div class="col-6 mx-auto">
                                                                <select
                                                                    type="text"
                                                                    class="form-control"
                                                                    name="searchProduct"
                                                                    id="searchProduct"
                                                                    placeholder="Ürün Adı veya Model Numarası yaz...">
                                                                    <option value=""></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="card card-xl-stretch shadow-sm mb-xl-8 searched-product w-400px border position-absolute bottom-0 start-50 translate-middle-x"
                                                        style="display: none;">
                                                        <!--begin::Body-->
                                                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                                                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                                                <span class="fw-bold text-dark fs-4 mb-2 searched-product-name"></span>
                                                                <span class="fw-bolder text-muted fs-5 searched-product-code"></span>
                                                            </div>
                                                            <i class="bi bi-droplet-half text-warning" style="font-size: 5.3rem !important;"></i>
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <div class="text-center px-4 searched-product-placeholder">
                                                        <img class="mw-100 mh-200px" alt="" src="{{ asset('assets/media/illustrations/sigma-1/17-dark.png') }}">
                                                    </div>
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Card-->
                                        </div>

                                    </div>
                                    <!--end::Step 2-->

                                    <!--begin::Step 3-->
                                    <div class="flex-column" style="min-height: 400px" data-kt-stepper-element="content">
                                        <div class="row mb-10" style="min-height: 400px">
                                            <div class="col-md-6 h-100">
                                                <div class="p-4 pe-14 h-100 border-end">
                                                    <h3 class="mb-14">Genel Bilgiler</h3>
                                                    <div class="mb-7">
                                                        <label for="shop">Satın Alınan Mağaza</label>
                                                        <select
                                                            data-control="select2"
                                                            data-placeholder="Mağaza Seçiniz"
                                                            id="shop"
                                                            name="store_bought"
                                                            class="form-control form-control-solid border js-example-basic-single"
                                                            >
                                                            <option value="">Seçiniz</option>
                                                                @foreach($stores as $item)
                                                                    <option value="{{ $item->musteri_kodu }}">{{ $item->musteri_kodu}} {{ $item->name}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                    <div class="mb-7">
                                                        <label for="warranty">Garanti Durumu</label>
                                                        <select
                                                            name="has_warranty"
                                                            id="warranty"
                                                            class="form-control form-control-solid border"
                                                            data-control="select2"
                                                            data-placeholder="Seçiniz"
                                                            data-hide-search="true"
                                                            >
                                                            <option value="">Seçiniz</option>
                                                            <option value="1">Garanti Süresi İçinde</option>
                                                            <option value="0">Garanti Süresi Dışında</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-7">
                                                        <label for="shop">Satış Tarihi</label>
                                                        <input type="text" name="sale_date" id="saleDate"
                                                            placeholder="Önce garanti durumunu seçiniz"
                                                            class="form-control form-control-solid border" readonly>
                                                    </div>
                                                    <div class="mb-7">
                                                        <label for="product_serial_number">Ürün Seri No</label>
                                                        <div class="position-relative">
                                                            <input type="text" name="product_serial_number" id="product_serial_number" class="form-control form-control-solid border" />
                                                        </div>
                                                    </div>
                                                    <div class="mb-7">
                                                        <label for="warrantyCode">Garanti Kodu</label>
                                                        <div class="position-relative">
                                                            <input type="text" name="warranty_code" id="warrantyCode" class="form-control form-control-solid border" maxlength="8" />
                                                            <div class="position-absolute top-50 end-0 translate-middle-y me-2 warranty-spinner" style="display: none;">
                                                                <div class="spinner-border text-info" style="display: block;" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="check-warranty-alert"></small>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-7">
                                                        <input class="form-check-input border" type="checkbox" name="no_warranty_card" id="no_warranty_card"/>
                                                        <label class="form-check-label" for="no_warranty_card">
                                                            <div class="fw-bolder">Garanti Belgesi</div>
                                                            <div class="text-gray-600">Garanti belgesi yok ise işaretleyiniz.</div>
                                                        </label>
                                                    </div>
                                                    <div class="mb-7">
                                                        <!--begin::Alert-->
                                                        <div class="alert alert-info bg-light-info d-flex align-items-center p-5 mb-10"
                                                            id="no_warranty_card_alert"
                                                            style="display: none !important;">
                                                            <span class="svg-icon svg-icon-2hx svg-icon-info me-4 mb-5 mb-sm-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M5.69477 2.48932C4.00472 2.74648 2.66565 3.98488 2.37546 5.66957C2.17321
                                                                        6.84372 2 8.33525 2 10C2 11.6647 2.17321 13.1563 2.37546 14.3304C2.62456
                                                                        15.7766 3.64656 16.8939 5 17.344V20.7476C5 21.5219 5.84211 22.0024
                                                                        6.50873 21.6085L12.6241 17.9949C14.8384 17.9586 16.8238 17.7361 18.3052
                                                                        17.5107C19.9953 17.2535 21.3344 16.0151 21.6245 14.3304C21.8268 13.1563 22
                                                                        11.6647 22 10C22 8.33525 21.8268 6.84372 21.6245 5.66957C21.3344 3.98488
                                                                        19.9953 2.74648 18.3052 2.48932C16.6859 2.24293 14.4644 2 12 2C9.53559 2
                                                                        7.31411 2.24293 5.69477 2.48932Z"
                                                                        fill="#191213">
                                                                    </path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M7 7C6.44772 7 6 7.44772 6 8C6 8.55228 6.44772 9 7 9H17C17.5523 9 18
                                                                        8.55228 18 8C18 7.44772 17.5523 7 17 7H7ZM7 11C6.44772 11 6 11.4477 6 12C6
                                                                        12.5523 6.44772 13 7 13H11C11.5523 13 12 12.5523 12 12C12 11.4477 11.5523 11 11 11H7Z"
                                                                        fill="#121319">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                                                <h5 class="mb-1 text-info">Dikkat</h5>
                                                                <span>Ürünün garanti belgesi yok ise fatura belgesi yüklenmesi zorunludur.</span>
                                                            </div>
                                                        </div>
                                                        <!--end::Alert-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 h-100">
                                                <div class="p-4 ps-14 h-100 border-start">
                                                    <h3 class="mb-14">Tüketici Şikayeti</h3>
                                                    <div class="mb-7">
                                                        <label for="complaint_category">Şikayet Kategori</label>
                                                        <select
                                                            name="complaint_category"
                                                            id="complaint_category"
                                                            class="form-control form-control-solid border"
                                                            data-control="select2"
                                                            data-placeholder="Seçiniz"
                                                            data-hide-search="true"
                                                            >
                                                            <option value="">Seçiniz</option>
                                                            @foreach($iris_categories as $category)
                                                                <option value="{{ $category->iris_kategori_kod }}-{{ $category->iris_kategori_desc }}">{{ $category->iris_kategori_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-7">
                                                        <label for="complaint_code">Şikayet Kodu</label>
                                                        <select
                                                            name="complaint_code"
                                                            id="complaint_code"
                                                            class="form-control form-control-solid border"
                                                            data-control="select2"
                                                            data-placeholder="Önce Şikayet Kategorisi Seçiniz"
                                                            data-hide-search="true"
                                                            >
                                                        </select>
                                                    </div>
                                                    <div class="mb-7">
                                                        <div class="form-floating">
                                                            <textarea class="form-control form-control-solid border"
                                                                name="complaint_text" id="complaint_text" style="height: 100px"></textarea>
                                                            <label for="complaint_text">Tüketici Şikayeti</label>
                                                            </div>
                                                    </div>
                                                    <div class="row mt-14">
                                                        <div class="col-6">
                                                            <button type="button"
                                                                data-bs-toggle="modal" data-bs-target="#invoiceUploadModal"
                                                                class="btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info d-flex w-100 position-relative"
                                                                    data-bs-toggle="modal" data-bs-target="#kt_urun_preview_modal" id="previewProdDocButton">
                                                                    <i class="far fa-file-alt fs-3x text-info"></i>
                                                                <div class="d-flex flex-stack flex-grow-1">
                                                                    <div class="fw-bold">
                                                                        <h4 class="text-gray-900 fw-bolder mt-3">Fatura Görselleri</h4>
                                                                    </div>
                                                                </div>
                                                                <span class="position-absolute top-0 start-100 translate-middle p-0 bg-light-success border border-success rounded-circle"
                                                                    style="width: 24px; height: 24px; font-size: 12px; line-height: 24px;">
                                                                    <span class="ivoice-count text-gray-600">0</span>
                                                                </span>
                                                            </button>
                                                            <small class="text-info d-block mt-4 ivoice-upload-alert-text"
                                                                style="display: none !important;">
                                                                (*) Lütfen fatura belgesi yükleyiniz.
                                                            </small>
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="button"
                                                                data-bs-toggle="modal" data-bs-target="#documentUploadModal"
                                                                class="btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info d-flex w-100 position-relative"
                                                                data-bs-toggle="modal" data-bs-target="#kt_urun_preview_modal" id="previewProdDocButton">
                                                                    <i class="far fa-images fs-3x text-info"></i>
                                                                <div class="d-flex flex-stack flex-grow-1">
                                                                    <div class="fw-bold">
                                                                        <h4 class="text-gray-900 fw-bolder mt-3">Ürün Belge ve Görselleri</h4>
                                                                    </div>
                                                                </div>
                                                                <span class="position-absolute top-0 start-100 translate-middle p-0 bg-light-success border border-success rounded-circle"
                                                                    style="width: 24px; height: 24px; font-size: 12px; line-height: 24px;">
                                                                    <span class="document-count text-gray-600">0</span>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Step 3-->
                                </div>
                                <!--end::Group-->

                                <!--begin::Actions-->
                                <div class="d-flex flex-stack">
                                    <div class="me-2">
                                        <button type="button" class="btn btn-light btn-active-light-primary"
                                            data-kt-stepper-action="previous">
                                            Önceki
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-kt-stepper-action="submit">
                                            <span class="indicator-label">
                                                Kaydet
                                            </span>
                                            <span class="indicator-progress">
                                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>

                                        <button type="button" class="btn btn-primary" data-kt-stepper-action="next" disabled="disabled">
                                            Sonraki
                                        </button>
                                    </div>
                                </div>
                                <!--end::Actions-->
                                <!-- begin::Modal - Fatura Yükle -->
                                <!-- Modal -->
                                <div class="modal fade" id="invoiceUploadModal" tabindex="-1" aria-labelledby="invoiceUploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light-info">
                                                <h5 class="modal-title w-100 text-center text-uppercase" id="invoiceUploadModalLabel">Fatura Belgeleri</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pb-1">
                                                <div class="custom-file-container" data-upload-id="invoiceUpload">
                                                    <label class="custom-file-container__custom-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-container__custom-file__custom-file-input"
                                                            id="invoiceUploadInput"
                                                            name="invoice_images"
                                                            accept="*"
                                                            multiple
                                                            aria-label="Dosya Seç"/>
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                    </label>
                                                    <div class="custom-file-container__image-preview mb-3"></div>
                                                    <label>
                                                        <a  href="javascript:void(0)"
                                                            class="custom-file-container__image-clear text-danger"
                                                            title="Tümünü Kaldır">
                                                            Tümünü Kaldır
                                                            <i class="las la-times"></i>
                                                        </a>
                                                    </label>
                                                </div>
                                                <div class="modal-footer p-0 py-3">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TAMAM</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end::Modal - Fatura Yükle -->

                                <!-- begin::Modal - Döküman / Ürün Resmi Yükle -->
                                <div class="modal fade" id="documentUploadModal" tabindex="-1" aria-labelledby="documentUploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light-info">
                                                <h5 class="modal-title w-100 text-center text-uppercase" id="documentUploadModalLabel">Ürün Resmi ve Ek Belgeler</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pb-1">
                                                <div class="custom-file-container" data-upload-id="documentUpload">
                                                    <label class="custom-file-container__custom-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-container__custom-file__custom-file-input"
                                                            id="documentUploadInput"
                                                            name="document_files"
                                                            accept="*"
                                                            multiple
                                                            aria-label="Dosya Seç"/>
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                    </label>
                                                    <div class="custom-file-container__image-preview mb-3"></div>
                                                    <label>
                                                        <a  href="javascript:void(0)"
                                                            class="custom-file-container__image-clear text-danger"
                                                            title="Tümünü Kaldır">
                                                            Tümünü Kaldır
                                                            <i class="las la-times"></i>
                                                        </a>
                                                    </label>
                                                </div>
                                                <div class="modal-footer p-0 py-3">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TAMAM</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end::Modal - Döküman / Ürün Resmi Yükle -->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Stepper-->
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
                <input type="hidden" name="consumerID">
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
                <input type="hidden" name="consumerID">
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

    <!-- begin::Modal - View Consumer Detail -->
    <div class="modal fade" id="kt_modal_consumer_history" tabindex="-1" style="display: none;" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <!--begin::Heading-->
                    <div class="text-center mb-13">
                        <h1 class="mb-3">Müşteri Geçmişi</h1>
                        <div class="text-muted fw-bold fs-5">
                            Müşteri geçmiş servis kayıtları.
                            <a href="#" class="link-primary fw-bolder">Çağrı Kayıtları</a>.
                        </div>
                    </div>
                    <!--end::Heading-->
                    <div class="results"></div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal - View Consumer Detail -->
@endsection

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <script>
        $(window).ready(function() {
            $("form").on("keypress", function (event) {
                console.log("aaya");
                var keyPressed = event.keyCode || event.which;
                if (keyPressed === 13) {
                    // alert("You pressed the Enter key!!");
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
    <script>
        let s1= false;
        let s2 = false;
        let s3 = false;

        // Stepper lement
        var element = document.querySelector("#kt_stepper_example_basic");

        // Initialize Stepper
        var stepper = new KTStepper(element);

        // Handle next step
        stepper.on("kt.stepper.next", function (stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function (stepper) {
            stepper.goPrevious(); // go previous step
        });

        stepper.on("kt.stepper.changed", function (stepper) {
            if (stepper.getCurrentStepIndex() == 3) {
                $('button[data-kt-stepper-action="submit"]').show();
            } else {
                $('button[data-kt-stepper-action="submit"]').hide();
            }
        });
    </script>

    <script>
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
        }).mask("#searchConsumerMobilePhone");

        Inputmask({
            "mask" : "(999) 999-9999",
            "placeholder": "(___) ___-____",
        }).mask("#add_consumer_phone");

        // Müşteri Ara
        $(document).on('click', '#consumerSearch', () => {
            let consumerSearchButton = $('#consumerSearch');
            let consumerSearchResults = $('#consumerSearchResults');

            let consumerName = $('#searchConsumerName').val();
            let consumerMobilePhone = $('#searchConsumerMobilePhone').val();

            if ( !consumerName && !consumerMobilePhone) {
                Toast.fire({
                    icon: 'error',
                    title: 'İsim Soyisim ya da Telefon numarasından birini giriniz!',
                    position: 'center'
                });
            } else {
                consumerSearchButton.attr("data-kt-indicator", "on");
                consumerSearchButton.attr("disabled", "disabled");

                $('#name').val(consumerName);
                $('#gsm').val(consumerMobilePhone);

                $.ajax({
                    type: "post",
                    url: "{{ route('consumer.consumerSearch') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        consumerName,
                        consumerMobilePhone
                    },
                    success: function (response) {
                        if (response != 'Bulunamadı') {
                            console.log(response);
                            consumerSearchResults.html('');
                            $.map(response.users, function (item, key) {
                                let html = `
                                    <div class="card card-flush border border-info shadow-sm py-1 mb-3">
                                        <div class="card-body d-flex justify-content-between py-5">
                                            <div>
                                                <div class="symbol symbol-35px me-5">
                                                    <div class="symbol-label bg-light-success">
                                                        <span class="text-success">${item.firstName.charAt(0)}</span>
                                                    </div>
                                                </div>
                                                <span class="fw-bold text-uppercase">${item.firstName} ${item.lastName}</span>
                                                <span class="text-gray-500"> - ${item.phone}</span>
                                            </div>
                                            <div class="card-toolbar">
                                                <span class="btn btn-light-info select-consumer"
                                                    data-firstname="${item.firstName}"
                                                    data-lastname="${item.lastName}"
                                                    data-mobilephone="${item.phone}"
                                                    data-consumerid="${item.id}">
                                                    Seç
                                                </span>
                                            </div>
                                        </div>
                                    </div>`;
                                consumerSearchResults.append(html);
                            });
                            consumerSearchButton.removeAttr("data-kt-indicator");
                            consumerSearchButton.removeAttr("disabled");
                        } else {
                            consumerSearchResults.html('');
                            let html = `
                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                    <span class="h3 text-gray-700">Sonuç Bulunamadı</span>
                                    <!--begin::Svg Icon | path: assets/media/icons/duotone/Code/Warning-2.svg-->
                                    <span class="svg-icon svg-icon-warning svg-icon-5x">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <path d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z" fill="#000000" opacity="0.3"/>
                                        <rect fill="#000000" x="11" y="9" width="2" height="7" rx="1"/>
                                        <rect fill="#000000" x="11" y="17" width="2" height="2" rx="1"/>
                                    </svg></span>
                                    <!--end::Svg Icon-->
                                    <span class="btn btn-light-success border border-success mt-4" data-bs-toggle="modal" data-bs-target="#add_consumer_modal">
                                        Yeni Müşteri Ekle
                                    </span>
                                </div>`;
                                consumerSearchResults.append(html);
                            consumerSearchButton.removeAttr("data-kt-indicator");
                            consumerSearchButton.removeAttr("disabled");
                            newConsumerForm();
                        }
                    }
                });
            }
        });

        // Müşteri Seç
        $(document).on('click', '.select-consumer', function() {
            let firstName = $(this).data('firstname');
            let lastName = $(this).data('lastname');
            let mobilePhone = $(this).data('mobilephone');
            let consumerid = $(this).data('consumerid');

            $('.consumer-invoices-button').attr('data-consumerid', consumerID);

            $('.consumerSearchSection').hide();
            $('#consumerLoading').show();

            //ConsumerCheck
            $.ajax({
                type: "POST",
                url: "{{ route('consumer.consumerCheck') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    first_name: firstName,
                    last_name: lastName,
                    mobile_phone: mobilePhone,
                    consumer_id: consumerid
                },
                success: function (response) {
                    if (response) {
                        $('#consumerLoading').hide();
                        $('#customerInfo').show();
                        $('#deliveredInfo').show();

                        $('#consumerFirstName').val(firstName);
                        $('#consumerLastName').val(lastName);
                        $('#consumerMobilePhone').val(mobilePhone);
                        $('#consumerID').val(response);
                        $('input[name="consumerID"]').val(response);

                        $('#slicedName').text(firstName.slice(0,1));
                        $('#consumerNameInfo').text(firstName + ' ' + lastName);
                        $('#consumerPhoneInfo').text(mobilePhone);
                        $('#resultSection').fadeOut();
                        $('button[data-kt-stepper-action="next"]').removeAttr('disabled');
                    }
                }
            });
        })

        // serializeObject Fonksiyonu
        $.fn.serializeObject = function(){
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };

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
            $('#consumerAddress').html(html);
        }

        //Yeni Müşteri Fonksiyonu
        function newConsumerForm() {
            let consumerName = $('#searchConsumerName').val();
            let consumerMobilePhone = $('#searchConsumerMobilePhone').val().replace(/[^0-9\.]/g, '');

            if (consumerMobilePhone.length < 10 && consumerName.length == 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Numara alanı boş bırakılamaz.',
                    position: 'center'
                });
            } else {
                $('#add_consumer_modal').modal('show');
                $('#add_consumer_form input[name="firstName"]').val(consumerName);
                $('#add_consumer_form #add_consumer_phone').val(consumerMobilePhone);
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
            let consumerID = $('input[name="consumerID"]').val();

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
            let consumerID = $('input[name="consumerID"]').val();

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
        $(document).on('click', '#updateConsumerAddress', function () {
            let selectedAddress = $('#consumerAddress').val();

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
            let consumerID = $('input[name="consumerID"]').val();
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

        //Müşteri Servis kayıtları
        $(document).on('click', '.consumer-services-button', function () {
            let button = $(this);
            let consumerID = $('input[name="consumerID"]').val();
            button.attr("data-kt-indicator", "on");
            button.attr("disabled", "disabled");

            $.ajax({
                type: "post",
                url: "{{ route('service.consumerServiceClaims') }}",
                data: {
                    _token : "{{ csrf_token() }}",
                    consumerID : consumerID
                },
                success: function (response) {
                    console.log(response);
                    let html = '';
                    html += `<div class="mb-15"> <div class="mh-375px scroll-y me-n7 pe-7">`;
                        $.each(response, function (index, item) {
                            html += `
                            <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-primary text-primary fw-bold">
                                            ${item.service_name.slice(0,1)}
                                        </span>
                                    </div>
                                    <div class="ms-6">
                                        <span class="fw-bold text-dark">${item.service_name}</span>
                                        <span class="badge badge-light fs-8 fw-bold">${item.product_name}</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="text-end">
                                        <div class="fs-7 text-muted">${item.created_at}</div>
                                    </div>
                                </div>
                            </div>`;
                        });
                    html += `</div></div>`;
                    $('#kt_modal_consumer_history .results').html(html);
                    $('#kt_modal_consumer_history').modal('show');
                    button.removeAttr("data-kt-indicator");
                    button.removeAttr("disabled");
                }
            });
        });

        //Teslim Eden Bilgisi Ek Alanlar - Radio Buttons
        $(document).on('click', "input:radio[name='teslim-eden']", function () {
            let val = $("input:radio[name='teslim-eden']:checked").val();

            switch (val) {
                case '2':
                    $('#shipping-section').show();
                    $('#consumer-address').hide();
                    $('#consignor').hide();
                    break;
                case '3':
                    $('#shipping-section').hide();
                    $('#consumer-address').show();
                    $('#consignor').hide();
                    getConsumerAddresses($('#consumerID').val());
                    break;
                case '9':
                    $('#shipping-section').hide();
                    $('#consumer-address').hide();
                    $('#consignor').show();
                    break;
                default:
                    $('#shipping-section').hide();
                    $('#consumer-address').hide();
                    $('#consignor').hide();
                    break;
            }
        });

        //Satış Tarihi - DatePicker
        $('#warranty').on('change', function() {
            if(this.value == 1) {
                var dt = new Date();
                dt.setDate(dt.getDate() - 730);

                var nowDate = new Date();
                var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                $("#saleDate").daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: dt,
                    maxDate: today,
                    maxYear: parseInt(moment().format("YYYY"),10),
                    locale: {
                        format: 'YYYY-M-DD'
                    }
                });
            } else {
                $("#saleDate").daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: 1901,
                    maxYear: parseInt(moment().format("YYYY"),10),
                    locale: {
                        format: 'YYYY-M-DD'
                    }
                });
            }
        });
    </script>

    <script>
        // Ürün Ara
        $("#searchProduct").select2({
            ajax: {
                // url: "https://api.github.com/search/repositories",
                url: "{{ route('productSearch') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        // page: params.page
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data,
                    };
                }
            },
            placeholder: 'Ürün bulmak için tıklayın.',
            minimumInputLength: 4,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        // Ürün Seç
        $("#searchProduct").on('select2:select', function (e) {
            $('.searched-product').hide();
            var data = e.params.data;
            console.log(data);
            $('#iris_kategori').val(data.iris_kategori);
            $('#product_id').val(data.id);
            $('#product_name').val(data.product_name);
            $('#product_code').val(data.product_code);
            $('.searched-product').slideDown(500);
            $('.searched-product-name').text(data.product_name);
            $('.searched-product-code').text(data.product_code);
            $('button[data-kt-stepper-action="next"]').removeAttr('disabled');
        });

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository'>" +
                    "<div class='select2-result-repository__meta' data-id="+ repo.id +" >" +
                        "<div class='select2-result-product_name'>" + repo.product_name + "</div>" +
                        "<div class='select2-result-product_code text-gray-400'>"+ repo.product_code +"</div>" +
                    "</div>" +
                "</div>"
            );

            return $container;
        };

        function formatRepoSelection (repo) {
            return repo.product_code || repo.text;
        };
    </script>

    <script>
        //Garanti belgesi kontrolü
        $(document).on('click', '#no_warranty_card', function() {
            if ($('#no_warranty_card').is(':checked')) {
                $('#no_warranty_card_alert').show();
                $('.ivoice-upload-alert-text').show();
            } else {
                $('#no_warranty_card_alert').attr('style','display:none !important');
                $('.ivoice-upload-alert-text').attr('style','display:none !important');
            }
        });

        //Garanti kodu kontrolü
        $("#warrantyCode").keyup(function () {
            urunKodu = $('#product_code').val(),
            garantiKodu = $(this).val(),
            satis_tarihi = $('#saleDate').val();

            if (garantiKodu.length > 7) {
                $('.warranty-spinner').show();
                $.ajax({
                    type: "POST",
                    url: "{{ route('service.checkWarranty') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        'garantiKodu' : garantiKodu,
                        'urunKodu' : urunKodu,
                        'satis_tarihi' : satis_tarihi
                    },
                    dataType: 'JSON',
                    success: function(data){
                        console.log(data);
                        $('.warranty-spinner').hide();
                        if (data == true) {
                            $('#no_warranty_card').attr('disabled', false);
                            if (!$('#no_warranty_card').is(':checked')) {
                                $('#no_warranty_card').trigger('click');
                            }
                            $('#no_warranty_card').trigger('click');
                            $('#no_warranty_card').attr('disabled', false);
                            $('.check-warranty-alert').text('Garanti belgesi doğrulandı.');
                            $('.check-warranty-alert').removeClass('text-danger').addClass('text-success');
                        } else {
                            if (!$('#no_warranty_card').is(':checked')) {
                                $('#no_warranty_card').trigger('click');
                            }
                            $('#no_warranty_card').attr('disabled', true);
                            $('.check-warranty-alert').text('Garanti belgesi doğrulanamadı. Lütfen fatura belgesi yükleyiniz.');
                            $('.check-warranty-alert').removeClass('text-success').addClass('text-danger');
                        }
                    }
                });
            } else {
                $('.warranty-spinner').hide();
            }
        });

        //Şikayet Kodu
        $('#complaint_category').on('select2:select', function (e) {
            let iris_kategori_kod = e.params.data.id;
            let iris_kategori = $('#iris_kategori').val();

            $.ajax({
                type: 'GET',
                url: "{{ route('getIrisCodes') }}",
                data: {
                    iris_kategori : iris_kategori,
                    iris_kategori_kod: iris_kategori_kod
                },
                success: function (data) {
                    if (data) {
                        $("#complaint_code").select2({
                            placeholder: {
                                id: '', // the value of the option
                                text: 'Seçiniz'
                            }
                        });
                        let html = `<option value=""></option>`;
                        $.each(data, function (index, value) {
                            html += `<option value="${value.id}-${value.iris_code_tr}">${value.iris_code_tr}</option>`;
                        });
                        $('#complaint_code').html(html);
                    }
                }
            });
        });
    </script>

    <script src="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.js"></script>
    <script>
        var invoiceUpload = new FileUploadWithPreview("invoiceUpload");
        var documentUpload = new FileUploadWithPreview("documentUpload");

        window.addEventListener("fileUploadWithPreview:imagesAdded", function (e) {
            if (e.detail.uploadId === "invoiceUpload") {
                $('.ivoice-count').text(e.detail.cachedFileArray.length)
            }
            if (e.detail.uploadId === "documentUpload") {
                $('.document-count').text(e.detail.cachedFileArray.length)
            }
        });
        window.addEventListener("fileUploadWithPreview:imageDeleted", function (e) {
            if (e.detail.uploadId === "invoiceUpload") {
                $('.ivoice-count').text(e.detail.cachedFileArray.length)
            }
            if (e.detail.uploadId === "documentUpload") {
                $('.document-count').text(e.detail.cachedFileArray.length)
            }
        });
    </script>
@endsection
