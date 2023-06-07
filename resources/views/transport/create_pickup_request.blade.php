@extends('common.layout')
@section('head')
<style>
    #email-error {
        position: absolute;
        bottom: -20px;
    }
</style>
@endsection
@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <div class="stepper stepper-pills" id="create_pickup_request">
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
                                    Teslimat
                                </h3>

                                <div class="stepper-desc">
                                    Teslimat Detayları
                                </div>
                            </div>
                        </div>
                        <div class="stepper-item mx-2 my-4" data-kt-stepper-element="nav">
                            <div class="stepper-line w-40px"></div>
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">4</span>
                            </div>
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Ödeme
                                </h3>

                                <div class="stepper-desc">
                                    Ödeme Detayları
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="form mx-auto" 
                        action="{{ route('bicozumExpress.storePickupRequest') }}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        novalidate="novalidate" 
                        id="kt_stepper_example_basic_form">
                        @csrf
                        <div class="mb-5">
                            <div class="flex-column current" style="min-height: 400px" data-kt-stepper-element="content">
                                <input type="hidden" name="consumerFirstName" id="consumerFirstName">
                                <input type="hidden" name="consumerLastName" id="consumerLastName">
                                <input type="hidden" name="consumerMobilePhone" id="consumerMobilePhone">
                                <input type="hidden" name="consumerID" id="consumerID">
                                <div class="row mt-5 consumerSearchSection">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 mb-10">
                                                <label for="searchConsumerName" class="form-label">İsim</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    id="searchConsumerName" placeholder="İsim" />
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-10">
                                                    <label for="searchConsumerMobilePhone"
                                                        class="form-label">Telefon</label>
                                                    <input type="tel" class="form-control form-control-solid"
                                                        id="searchConsumerMobilePhone" placeholder="(XXX) XXX XXXX" data-mask="(999) 999-9999"/>
                                                </div>
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
                                                <img class="mw-100 mh-200px" alt="" src="/assets/media/illustrations/support.png">
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
                                    <div class="col-lg-12 mb-5 mb-xl-8" id="customerInfo" style="display: none;">
                                        <div class="card card-dashed border-info shadow-sm">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <div class="pb-10 pb-lg-12">
                                            <h2 class="fw-bolder text-dark">Ürün Bilgisi Ekle</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Ürün</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Talep Türü</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Tüketici Şikayeti</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Garanti Durumu</label>
                                            </div>
                                            <div class="col-md-1">
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select form-select-solid mb-2 product" id="product_id" name="product_id">
                                                    <option value=""></option>
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-productName="{{ $item->product_name }}"
                                                            data-productSapCode="{{ $item->product_sap_code }}"
                                                            data-productCode="{{ $item->product_code }}">
                                                            {{ $item->product_code }} {{ $item->product_sap_code }} {{ $item->product_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-select form-select-solid" required id="reason" name="reason" placheholder="Talep Türü" data-fouc>
                                                    <option value="">Seçiniz</option>
                                                    <option value="servis_ariza">{{ config('sebportal.musteri_talep.servis_ariza') }}</option>
                                                    <option value="para_iadesi">{{ config('sebportal.musteri_talep.para_iadesi') }}</option>
                                                    <option value="diger">Diğer</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="description" id="description" placeholder="Tüketici Şikayeti" required class="form-control form-control-solid">
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-select form-select-solid" required id="has_warranty" name="has_warranty" placeholder="Garanti Durumu" data-fouc>
                                                    <option value="">Seçiniz</option>
                                                    <option value="var">Var</option>
                                                    <option value="yok">Yok</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary addProduct" id="urunEkle">Ekle</button>
                                            </div>
                                        </div>
                                        <br><br>
                                        <table class="table table-row-bordered table-row-gray-300 gy-7" id="dynamicProducts">
                                            <thead>
                                                <tr class="fw-bolder fs-6 text-gray-800">
                                                    <th>Ürün Kodu</th>
                                                    <th>Ürün Adı</th>
                                                    <th>Talep Türü</th>
                                                    <th>Tüketici Şikayeti</th>
                                                    <th>Garanti</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="form-group row bg-light pt-4 pb-2" id="productPricing" style="display: none">
                                            <div class="col-sm-4">
            
                                            </div>
                                            <div class="col-sm-4">
                                                <h3> Toplam Eklenen Ürün Sayısı  :   <span id="totalProductCount"></span></h3>
                                                <input type="hidden" name="totalProductCountInput" id="totalProductCountInput">
                                            </div>
                                            <div class="col-sm-4">
                                                <h3> Taşıma Ücreti  :  <span id="shippingPrice"></span></h3>
                                                <input type="hidden" name="shippingPriceInput" id="shippingPriceInput">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <div class="pb-10 pb-lg-12">
                                            <h2 class="fw-bolder text-dark">Teslimat Bilgisi Ekle</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card card-xxl-stretch shadow-sm mb-5">
                                                <div class="card-header align-items-center border-0 mt-4">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="fw-bolder mb-2 text-dark">Alınacak Adres</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body pt-1">
                                                    <div class="form-group">
                                                        
                                                        <div class="form-check form-check-inline form-check-right mb-3">
                                                            <label class="form-check-label">
                                                                Mağazadan Alınacak
                                                                <input type="radio" class="form-check-input magazaAlim" name="from_type" id="from_type" value="1" onclick="handleClick_alim(this);">
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="form-check form-check-inline form-check-right">
                                                            <label class="form-check-label">
                                                                Müşteri Adresinden Alınacak
                                                                <input type="radio" class="form-check-input musteriAlim" name="from_type" id="from_type" value="2" onclick="handleClick_alim(this);">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pt-5"  id="al_magaza" style="display:none">
                                                        <label>Mağaza</label>
                                                        <select id="from_store" name="from_store" class="form-control select-search">
                                                            <option value="">Seçiniz</option>
                                                            @foreach($stores as $item)
                                                                <option value="{{ $item->musteri_kodu }}" @if(Auth::user()->magaza_id==$item->id ) selected @endif >{{ $item->musteri_kodu}} {{ $item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group pt-5"  id="al_musteri" style="display:none">
                                                        <label>Müşteri Adresi</label>
                                                        <select id="consumerAddress" name="from_customer" class="form-control alimAdres"></select>
                                                        <p></p>
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
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card card-xxl-stretch shadow-sm mb-5">
                                                <div class="card-header align-items-center border-0 mt-4">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="fw-bolder mb-2 text-dark">Bırakılacak Adres</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body pt-1">
                                                    <div class="form-group">
                                                        
                                                        <div class="form-check form-check-inline form-check-right mb-3">
                                                            <label class="form-check-label">
                                                                Mağazaya Bırakılacak
                                                                <input type="radio" class="form-check-input magazaTeslim" name="to_type" id="to_type" value="1" onclick="handleClick_teslim(this);">
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="form-check form-check-inline form-check-right">
                                                            <label class="form-check-label">
                                                                Müşteri Adresine Bırakılacak
                                                                <input type="radio" class="form-check-input musteriTeslim" name="to_type" id="to_type" value="2" onclick="handleClick_teslim(this);">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pt-5" id="birak_magaza" style="display:none">
                                                        <label>Mağaza</label>
                                                        <select id="to_store" name="to_store" class="form-control select-search">
                                                            <option value="">Seçiniz</option>
                                                            @foreach($stores as $item)
                                                                <option value="{{ $item->musteri_kodu }}"  @if(Auth::user()->magaza_id==$item->id ) selected @endif >{{ $item->musteri_kodu}} {{ $item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group pt-5" id="birak_musteri" style="display:none">
                                                        <label>Müşteri Adresi</label>
                                                        <select id="consumerAddress" name="to_customer" class="form-control teslimAdres"></select>
                                                        <p></p>
                                                        <button 
                                                            type="button" 
                                                            id="newConsumerAddress"
                                                            class="btn btn-info btn-sm" 
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#create_consumer_address_modal">
                                                            Yeni Adres Ekle
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <div class="pb-10 pb-lg-12">
                                            <h2 class="fw-bolder text-dark">Ödeme Bilgisi Ekle</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card card-xxl-stretch shadow-sm mb-5">
                                                <div class="card-header align-items-center border-0 mt-4">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="fw-bolder mb-2 text-dark">Ödeme Yönetimi</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body pt-1">
                                                    <ul class="list-group">
                                                        <li class="list-group-item border-0">
                                                            <div class="form-check form-check-custom form-check-solid mb-5">
                                                                <input class="form-check-input" name="odeyen" type="radio" value="musteri_oder" checked="checked" id="musteri_oder_radio" onclick="handleClick_odeyen(this);"/>
                                                                <label class="form-check-label" for="musteri_oder_radio">
                                                                    Müşteri Öder
                                                                </label>
                                                            </div>
                                                            <ul class="list-group my-2" id="musteriodersecenekleri">
                                                                <li class="list-group-item border-0">
                                                                    <div class="form-check form-check-custom form-check-solid">
                                                                        <input class="form-check-input" name="odeme_tipi" type="radio" value="nakit" id="nakit_radio" checked="checked"/>
                                                                        <label class="form-check-label" for="nakit_radio">
                                                                            Kapıda Nakit
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item border-0">
                                                                    <div class="form-check form-check-custom form-check-solid">
                                                                        <input class="form-check-input" name="odeme_tipi" type="radio" value="kredikarti" id="kredikarti_radio"/>
                                                                        <label class="form-check-label" for="kredikarti_radio">
                                                                            Kapıda Kredi Kartı
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            <div class="form-check form-check-custom form-check-solid mb-5">
                                                                <input class="form-check-input" name="odeyen" type="radio" value="groupseb_oder" id="groupseb_oder_radio" onclick="handleClick_odeyen(this);"/>
                                                                <label class="form-check-label" for="groupseb_oder_radio">
                                                                    GroupSeb Öder
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card card-xxl-stretch shadow-sm mb-5">
                                                <div class="card-header align-items-center border-0 mt-4">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="fw-bolder mb-2 text-dark">Ürün ve Ücretlendirme</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body pt-1">
                                                    <div class="flex-grow-1 card-p pb-0">
                                                        <div class="d-flex flex-stack flex-wrap mb-5">
                                                            <div class="me-2">
                                                                <span class="text-dark text-hover-primary fw-bolder fs-3">Toplam Eklenen Ürün Sayısı</span>
                                                            </div>
                                                            <div class="fw-bolder fs-3 text-primary totalProductCount"></div>
                                                        </div>
                                                        <div id="tutar">
                                                            <div class="d-flex flex-stack flex-wrap">
                                                                <div class="me-2">
                                                                    <span class="text-dark text-hover-primary fw-bolder fs-3">Taşıma Ücreti</span>
                                                                </div>
                                                                <div class="fw-bolder fs-3 text-primary tutarDiv"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-stack pt-10">
                            <div class="me-2">
                                <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                    <span class="svg-icon svg-icon-3 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1"></rect>
                                                <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"></path>
                                            </g>
                                        </svg>
                                    </span>Geri
                                </button>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        Kaydet
                                        <span class="svg-icon svg-icon-3 ms-2 me-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                                    <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                    İleri
                                    <span class="svg-icon svg-icon-3 ms-1 me-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

        <!--begin::Modals-->
        <!-- begin::Modal - Müşteri Ekle -->
        <div id="create_consumer_modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                                <!--begin::Svg Icon | path: assets/media/icons/duotone/General/User.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
                            </svg></span>
                            <!--end::Svg Icon-->
                            <h5 class="modal-title ms-3">Müşteri Ekle</h5>
                        </div>
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
                        <form id="createConsumer">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group row mb-5">
                                    <label class="col-form-label col-lg-3">Adı Soyadı</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" required name="name" id="name" placeholder="Adı">
                                            <input type="text" class="form-control" required name="surname" id="name" placeholder="Soyadı">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <label class="col-form-label col-lg-3">Telefon</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" required  data-mask="(999) 999-9999" placeholder="Telefon" name="gsm" id="gsm">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <label class="col-form-label col-lg-3">E-posta</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <input type="email" class="form-control" placeholder="E-mail" name="email" id="email">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-5 mt-3">
                                    <label class="col-form-label col-lg-3">Adres Adı</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="contacttype" id="contacttype" placeholder="Adres Adı">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <label class="col-form-label col-lg-3">Adres</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <textarea type="text" class="form-control" required  placeholder="Açık Adres" name="address" id="adres"></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row mb-5">
                                    <label class="col-form-label col-lg-3">İl</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <select name="city" class="form-control city" required>
                                                <option value="">İl Seçiniz</option>
                                                @foreach($cities as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">İlçe</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <select name="town" class="form-control town" required>
                                                <option value="">Önce İl Seçiniz</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary submit-customer-button">
                            <span class="indicator-label">
                                Ekle
                            </span>
                            <span class="indicator-progress">
                                Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end::Modal - Müşteri Ekle -->

        <!-- begin::Modal - Müşteri Adresi Ekle -->
        <div id="create_consumer_address_modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
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
                    <div class="create_consumer_address">
                        <div class="modal-body">

                            <div class="form-group row mb-5">
                                <label class="col-form-label col-lg-3">Adres Adı</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Adres Adı (Ev, İş, vb)" name="address_name" id="address_name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <label class="col-form-label col-lg-3">Adres</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <textarea type="text" class="form-control"  placeholder="Açık Adres" name="address" id="address"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <label class="col-form-label col-lg-3">İl</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <select name="address_city" id="address_city" required class="form-control"">
                                            <option>İl Seçiniz</option>
                                            @foreach($cities as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3">İlçe</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <select name="address_town" id="address_town" required class="form-control"">
                                            <option value="">Önce İl Seçiniz</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info create-consumer-address-submit-button">
                                <span class="indicator-label">
                                    Ekle
                                </span>
                                <span class="indicator-progress">
                                    Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end::Modal - Müşteri Adresi Ekle -->

        <!-- begin::Modal - Müşteri Adresi Güncelle -->
        <div id="update_consumer_address_modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-map-marked-alt fs-1 text-primary me-4"></i> Müşteri Adresi Güncelle</h5>
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
                    <div id="update_consumer_address">
                        <div class="modal-body">
                            <input type="hidden" name="address_id">
                            <div class="form-group row mb-5">
                                <label class="col-form-label col-lg-3">Adres Adı</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Adres Adı (Ev, İş, vb)" name="address_name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <label class="col-form-label col-lg-3">Adres</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <textarea type="text" class="form-control"  placeholder="Açık Adres" name="address"></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row mb-5">
                                <label class="col-form-label col-lg-3">İl</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <select name="city" required class="form-control">
                                            <option value="">İl Seçiniz</option>
                                            @foreach($cities as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3">İlçe</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <select name="town" class="form-control">
                                            <option value="">Önce İl Seçiniz</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info update-consumer-address-submit-button">
                                <span class="indicator-label">
                                    Güncelle
                                </span>
                                <span class="indicator-progress">
                                    Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end::Modal - Müşteri Adresi Güncelle -->
        <!--end::Modals-->
    </div>
    <!--end::Container-->
@endsection
@section('footer_scripts')
<script>
    var i = 0;
    var urun = [];
    let s1= false;
    let s2 = false;
    let s3 = false;
    var element = document.querySelector("#create_pickup_request");
    var stepper = new KTStepper(element);
    stepper.on("kt.stepper.next", function (stepper) {
        if (stepper.getCurrentStepIndex() == 1) {
            if($('#consumerID').val().length < 1) {
                toastMessage("Müşteri bilgisinin girilmesi zorunludur.", "error");
            } else {
                $.when(stepper.goNext()).then(function () { s1 = true });
            }
        }
        if (stepper.getCurrentStepIndex() == 2 && s1 == true) {
            let urunVarMi = $('input[name^="urun"]').length;
            if (urunVarMi < 1) {
                toastMessage("Ürün bilgisinin girilmesi zorunludur.", "error");
            } else {
                $.when(stepper.goNext()).then(function () { s2 = true });
            }
        }
        if (stepper.getCurrentStepIndex() == 3 && s2 == true) {
            if ($("input[name='from_type']").is(':checked') && $("input[name='to_type']").is(':checked')) {
                $.when(stepper.goNext()).then(function () { s3 = true });
            } else {
                toastMessage("Teslimat bilgisinin girilmesi zorunludur.", "error");
            }
        }
        if (stepper.getCurrentStepIndex() == 4) {
            $('button[data-kt-stepper-action="submit"]').show();
        } else {
            $('button[data-kt-stepper-action="submit"]').hide();
        }
    });
    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious();
    });

    $("#kargo_teslim_tarihi").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format("YYYY"),10),
            locale: {
                format: 'YYYY-M-DD'
            }
        }
    );

    $('select.product').select2({
        minimumInputLength: 4,
        placeholder: 'Seçiniz',
        language: { inputTooShort: function () { return "Lütfen en az 4 karakter giriniz.."; } }
    });
    $('select.select-search').select2({
        minimumInputLength: 2,
        placeholder: 'Seçiniz',
        language: { inputTooShort: function () { return "Lütfen en az 2 karakter giriniz.."; } }
    });

    

    // Toast Message
    function toastMessage(message, type){
        toastr.options = {
            "closeButton": false,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        if (type == "error") {
            toastr.error(message);
        } else if (type == "warning") {
            toastr.warning(message);
        } else {
            toastr.success(message);
        }
    }
    
    // Müşteri Ara
    $(document).on('click', '#consumerSearch', () => {
        let consumerSearchButton = $('#consumerSearch');
        let consumerSearchResults = $('#consumerSearchResults');

        let consumerName = $('#searchConsumerName').val();
        let consumerMobilePhone = $('#searchConsumerMobilePhone').val();

        if ( !consumerName && !consumerMobilePhone) {
            toastMessage("İsim Soyisim ya da Telefon numarasından birini giriniz!", "error");
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
                                <span class="btn btn-light-success border border-success mt-4" data-bs-toggle="modal" data-bs-target="#create_consumer_modal">
                                    Yeni Müşteri Ekle
                                </span>
                            </div>`;
                            consumerSearchResults.append(html);
                        consumerSearchButton.removeAttr("data-kt-indicator");
                        consumerSearchButton.removeAttr("disabled");
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
                    
                    $('#slicedName').text(firstName.slice(0,1));
                    $('#consumerNameInfo').text(firstName + ' ' + lastName);
                    $('#consumerPhoneInfo').text(mobilePhone);
                    $('#resultSection').fadeOut();
                    $('button[data-kt-stepper-action="next"]').removeAttr('disabled');
                }
            }
        });
    });

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

    // Email Kontrol
    $(document).ready(function(){
        var startTimer;
        $('#email').on('keyup', function () {
            clearTimeout(startTimer);
            let email = $(this).val();
            startTimer = setTimeout(checkEmail, 500, email);
        });

        $('#email').on('keydown', function () {
            clearTimeout(startTimer);
        });

        function checkEmail(email) {
            $('#email-error').remove();
            if (email.length > 1) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('consumer.consumerCheckEmail') }}",
                    data: {
                        email: email,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.success == false) {
                            $('#email').after('<div id="email-error" class="text-danger"><strong>'+data.message[0]+'<strong></div>');
                            $('#contacttype').addClass('mt-3');
                        } else {
                            $('#email').after('<div id="email-error" class="text-success"><strong>'+data.message+'<strong></div>');
                            $('#contacttype').addClass('mt-3');
                        }

                    }
                });
            } else {
                $('#email').after('<div id="email-error" class="text-danger" <strong>Email address can not be empty.<strong></div>');
                $('#contacttype').addClass('mt-3');
            }
        }
    });

    // Müşteri Ekle
    $(document).on('click', '.submit-customer-button', function() {
        let button = $(this);
        let formData = $('#createConsumer').serializeObject();

        button.attr("data-kt-indicator", "on");
        button.attr("disabled", "disabled");

        $.ajax({
            type: "post",
            url: "{{ route('consumer.createConsumer') }}",
            data: formData,
            success: function (response) {
                console.log(response);
                $('#create_consumer_modal').modal('hide');
                button.removeAttr("data-kt-indicator");
                button.removeAttr("disabled");
                let data = JSON.parse(response);
                if (data.Result) {
                    toastMessage('Tebrikler! Müşteri eklendi.', 'success');
                } else {
                    toastMessage('Hata! Müşteri eklenemedi.', 'error');
                }
            }
        });
    });

    //AJAX  İlçeler
    function getTowns(city, resultDiv, selected) { 
        $.ajax({
            type: "post",
            url: "{{ route('towns') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'city': city
            },
            success: function (response) {
                // console.log(response);
                if (response) {
                    let html = '<option value="">Seçiniz</value>';
                    response.map((item) => {
                        html += `<option value="${item.id}" ${ item.id == selected ? 'selected' : '' }>${item.ilce_adi}</option>`;
                    })
                    $(resultDiv).html(html);
                }
            }
        });
    }

    //Müşteri Ekle Form - İlçeler
    $(document).on('change', '.city', (arguments) => {
        let city = $('#create_consumer_modal .city').val();
        getTowns(city, '#create_consumer_modal .town');
    });

    //Müşteri Adresi Ekle Formu - İlçeler
    $(document).on('change', '#address_city', (arguments) => {
        let city = $('#address_city').val();
        getTowns(city, '#address_town');
    });
    
    //Müşteri Adresi Güncelle Formu - İlçeler
    $(document).on('change', '#update_consumer_address select[name="city"]', (arguments) => {
        let city = $('#update_consumer_address select[name="city"]').val();
        getTowns(city, '#update_consumer_address select[name="town"]');
    });

    //Müşteri Adresleri
    function getConsumerAddress(consumerID) {
        $('#consumerAddress').html('');
        var _token = "{{ csrf_token() }}";
        $.ajax({
            url:"{{ route('consumer.getConsumerAddress') }}",
            method:"POST",
            data:{
                _token:_token,
                consumer_id:consumerID
            },
            success:function(response){
                console.log(response);
                let data = JSON.parse(response);
                let html = '<option value="">Adres seçiniz</option>';
                $.map(data, function (item, key) {
                    html += `<option value="${item.id}">${item.address_name} - ${item.address} ${item.town}/${item.city}</option>`;
                });
                $('#consumerAddress').html(html);
            }
        });
    }

    //Müşteri Adresi Ekle
    $(document).on('click', '.create-consumer-address-submit-button', function () {
        let createConsumerAddressButton = $('.create-consumer-address-submit-button');
        let consumerID = $('#consumerID').val();
        let addressName = $('.create_consumer_address #address_name').val();
        let address = $('.create_consumer_address #address').val();
        let addressCity = $('.create_consumer_address #address_city').val();
        let addressTown = $('.create_consumer_address #address_town').val();

        createConsumerAddressButton.attr("data-kt-indicator", "on");
        createConsumerAddressButton.attr("disabled", "disabled");

        $.ajax({
            type: "POST",
            url: "{{ route('consumer.createConsumerAddress') }}",
            data: {
                _token: '{{ csrf_token() }}',
                consumer_id: consumerID,
                address_name: addressName,
                address: address,
                city: addressCity,
                town: addressTown,
            },
            success: function (response) {
                if (response) {
                    getConsumerAddress($('#consumerID').val());
                    createConsumerAddressButton.removeAttr("data-kt-indicator");
                    createConsumerAddressButton.removeAttr("disabled");
                    $('#create_consumer_address_modal').modal('toggle');
                    toastMessage('Tebrikler! Adres başarılı bir şekilde eklendi.', 'success');
                }
            }
        });
    });

    //Müşteri Adresi Güncelle - Modal
    $(document).on('click', '#updateConsumerAddress', function () {
        let selectedAddress = $('#consumerAddress').val();

        if (selectedAddress > 0) {
            $('#update_consumer_address input[name="id"]').val('');
            $('#update_consumer_address input[name="address_name"]').val('');
            $('#update_consumer_address textarea[name="address"]').text('');
            $('#update_consumer_address select[name="city"]').val('');
            $('#update_consumer_address select[name="town"]').val('');

            $.ajax({
                type: "POST",
                url: "{{ route('consumer.getSelectedAddress') }}",
                data: {_token: "{{ csrf_token() }}" ,address_id: selectedAddress},
                success: function (response) {
                    if (response) {
                        $('#update_consumer_address input[name="address_id"]').val(response.id);
                        $('#update_consumer_address input[name="address_name"]').val(response.address_name);
                        $('#update_consumer_address textarea[name="address"]').text(response.address);
                        $('#update_consumer_address select[name="city"]').val(response.city).change();
                        getTowns(response.city, '#update_consumer_address select[name="town"]', response.town);
                    }
                }
            }).done(function(){
                $('#update_consumer_address_modal').modal('toggle');
            });
        } else {
            toastMessage('Güncelleme için geçerli bir adres seçimi yapmadınız.', 'error')
        }
    });

    //Müşteri Adresi Güncelle
    $(document).on('click', '.update-consumer-address-submit-button', function () {
        let updateConsumerAddressButton = $('.update-consumer-address-submit-button');

        let consumerID = $('input[name="consumerID"]').val();
        let addressID = $('#update_consumer_address input[name="address_id"]').val();
        let addressName = $('#update_consumer_address input[name="address_name"]').val();
        let address = $('#update_consumer_address textarea[name="address"]').text();
        let city = $('#update_consumer_address select[name="city"]').val();
        let town = $('#update_consumer_address select[name="town"]').val();

        updateConsumerAddressButton.attr("data-kt-indicator", "on");
        updateConsumerAddressButton.attr("disabled", "disabled");

        console.log(consumerID);

        $.ajax({
            type: "POST",
            url: "{{ route('consumer.updateConsumerAddress') }}",
            data: {
                _token: '{{ csrf_token() }}',
                address_id: addressID,
                address_name: addressName,
                address: address,
                city: city,
                town: town
            },
            success: function (response) {
                updateConsumerAddressButton.removeAttr("data-kt-indicator");
                updateConsumerAddressButton.removeAttr("disabled");
            }
        }).done(function () {
            $('#update_consumer_address_modal').modal('toggle');
            getConsumerAddress(consumerID);
            toastMessage('Adres başarılı bir şekilde güncellendi.', 'success');
        });
    });

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $('.addProduct').click(function(e){
        e.preventDefault();
        i++;
        let product_id = $('#product_id').val();
        let product_name = $('#product_id').find(':selected').attr('data-productName');
        let product_sap_code = $('#product_id').find(':selected').attr('data-productSapCode');
        let product_code = $('#product_id').find(':selected').attr('data-productCode');
        let reason = $('#reason').val();
        let description = $('#description').val();
        let has_warranty = $('#has_warranty').val();
        
        $("#product_id").val('').trigger('change');
        $('#reason').val("");
        $('#description').val("");
        $('#has_warranty').val("");

        if (product_id == '' || reason == '' || description == '' || has_warranty == '') {
            toastMessage("Ürün bilgisinin girilmesi zorunludur.", "error");
        } else {
            $('#dynamicProducts tbody').append(`
                <tr id="row`+i+`">
                    <td>`+product_sap_code+`<input type="hidden" name="urun[`+i+`][product_id]" value="`+product_id+`"></td>
                    <td>`+product_name+`<input type="hidden" name="urun[`+i+`][product_name]" value="`+product_name+`"></td>
                    <td>`+reason+`<input type="hidden" name="urun[`+i+`][reason]" value="`+reason+`"></td>
                    <td>`+description+`<input type="hidden" name="urun[`+i+`][description]" value="`+description+`"></td>
                    <td>`+has_warranty+`<input type="hidden" name="urun[`+i+`][has_warranty]" value="`+has_warranty+`"></td>
                    <td>
                        <input type="hidden" name="urun[`+i+`][product_code]" value="`+product_code+`">
                        <button type="button" name="remove" id="`+i+`" class="btn btn-danger btn-sm px-3 py-1 btn_remove">SİL</button>
                    </td>
                </tr>`
            );

            let rowCount = $("#dynamicProducts tbody tr").length;
            let shippingPrice = rowCount * 5000/100;

            $('#productPricing').show("slow");
            $('#totalProductCount').text(rowCount);
            $('#totalProductCountInput').val(rowCount);
            $('#shippingPrice').text(addCommas(shippingPrice)+'  ₺');
            $('#shippingPriceInput').val(shippingPrice);
            $('.totalProductCount').text(rowCount);
            $('.tutarDiv').text(addCommas(shippingPrice)+'  ₺');
        }
    });
    
    $(document).on('click', '.btn_remove', function(){  
        var button_id = $(this).attr("id");   
        $('#row'+button_id+'').remove();

        let rowCount = $("#dynamicProducts tbody tr").length;
        let shippingPrice = rowCount * 5000/100;

        $('#totalProductCount').text(rowCount);
        $('#totalProductCountInput').val(rowCount);
        $('#shippingPrice').text(addCommas(shippingPrice)+'  ₺');
        $('#shippingPriceInput').val(shippingPrice);
        $('.totalProductCount').text(rowCount);
        $('.tutarDiv').text(addCommas(shippingPrice)+'  ₺');
    });

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function getAlimAddress(magaza, musteri, resultDiv) {
        $('#'+magaza).hide();
        $('#'+musteri).show();
        var _token = "{{ csrf_token() }}";
        var consumerID = $('#consumerID').val();
        $.ajax({
            url:"{{ route('consumer.getConsumerAddress') }}",
            method:"POST",
            data:{
                _token:_token,
                consumer_id:consumerID
            },
            success:function(response){
                console.log(response);
                let data = JSON.parse(response);
                let html = '<option value="">Adres seçiniz</option>';
                $.map(data, function (item, key) {
                    html += `<option value="${item.id}">${item.address_name} - ${item.address} ${item.town}/${item.city}</option>`;
                });
                $(resultDiv).html(html);
            }
        });
    }

    function getTeslimAddress(magaza, musteri, resultDiv) {
        $('#'+magaza).hide();
        $('#'+musteri).show();
        var _token = "{{ csrf_token() }}";
        var consumerID = $('#consumerID').val();
        $.ajax({
            url:"{{ route('consumer.getConsumerAddress') }}",
            method:"POST",
            data:{
                _token:_token,
                consumer_id:consumerID
            },
            success:function(response){
                console.log(response);
                let data = JSON.parse(response);
                let html = '<option value="">Adres seçiniz</option>';
                $.map(data, function (item, key) {
                    html += `<option value="${item.id}">${item.address_name} - ${item.address} ${item.town}/${item.city}</option>`;
                });
                $(resultDiv).html(html);
            }
        });
    }

    function handleClick_alim(myRadio) {
        if(myRadio.value==1){
            $('#al_magaza').show();
            $('#al_musteri').hide();
        }
        if(myRadio.value==2){
            getAlimAddress("al_magaza", "al_musteri", ".alimAdres");
        }
    }

    function handleClick_teslim(myRadio) {
        if(myRadio.value==1){
            $('#birak_magaza').show();
            $('#birak_musteri').hide();
        }
        if(myRadio.value==2){
            getTeslimAddress("birak_magaza", "birak_musteri", ".teslimAdres");
        }
    }

    function handleClick_odeyen(myRadio) {
        if(myRadio.value=='musteri_oder'){
            $('#musteriodersecenekleri').show();
            $('#tutar').show();
        }
        if(myRadio.value=='groupseb_oder'){
            $('#musteriodersecenekleri').hide();
            $('#tutar').hide();
        }
    }
</script>
@endsection