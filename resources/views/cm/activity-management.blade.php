@extends('common.layout')

@section('content')
     <!--begin::Container-->
     <div class="container-xxl px-0" id="kt_content_container">
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
            <!--begin::Col-->
            <div class="col-xl-8 ps-xl-12">
                <!--begin::Engage widget 1-->
                <div class="card shadow min-h-200px mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body d-flex justiy-content-center align-items-center">
                        <div class="row w-100">
                            <div class="col-lg-8">
                                <div class="text-gray-600 min-w-300px position-relative my-8">
                                    <i class="fas fa-mobile-alt fs-3x position-absolute top-50 start-0 translate-middle-y"></i>
                                    <input type="text"
                                        id="called-phone" 
                                        class="form-control h-70px ms-12 fs-2x" 
                                        placeholder="(___) ___-____"
                                        autocomplete="off"/>
                                    <small></small>
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
                                <!--begin::Extra Searhc Fields-->
                                <div class="mt-8">
                                    <!--begin::Header-->
                                    <div class="py-0 d-flex flex-stack flex-wrap">
                                        <!--begin::Toggle-->
                                        <div class="d-flex align-items-center collapsible toggle collapsed" data-bs-toggle="collapse" data-bs-target="#extra_search_fields">
                                            <!--begin::Arrow-->
                                            <div class="btn btn-sm btn-icon btn-active-color-primary ms-n3 me-2">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                                <span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                                        <rect x="6.0104" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon toggle-off svg-icon-2">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                                        <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                                        <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Arrow-->
                                            <!--begin::Summary-->
                                            <div class="me-3">
                                                <div class="d-flex align-items-center text-muted">Diğer Arama Seçenekleri</div>
                                            </div>
                                            <!--end::Summary-->
                                        </div>
                                        <!--end::Toggle-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div id="extra_search_fields" class="collapse fs-6 ps-10">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap py-5">
                                           <!--begin::Input group-->
                                            <div class="input-group mb-5">
                                                <input type="text" 
                                                    id="search_extra_text"
                                                    class="form-control fs-7" 
                                                    placeholder="&quot;İSİM&quot; ya da &quot;MAİL&quot; ile arama yapabilirsizin." 
                                                    aria-describedby="search_extra_button"
                                                    autocomplete="off"/>
                                                <span class="btn btn-info" id="search_extra_button">
                                                    <span class="indicator-label">
                                                        BUL
                                                    </span>
                                                    <span class="indicator-progress">
                                                        <span class="spinner-border spinner-border-sm align-middle m-2"></span>
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Extra Searhc Fields-->
                            </div>
                            <div class="col-lg-4">
                                <div class="actions d-flex justify-content-end text-end pt-6">
                                    <span id="close-call" 
                                        class="btn btn-light-danger rounded-circle border border-danger w-80px h-80px d-flex justiy-content-center align-items-center ms-3">
                                        <i class="fas fa-phone-slash fs-3x"></i>
                                    </span>
                                    <span id="start-call"
                                        class="btn btn-light-success rounded-circle border border-success w-80px h-80px d-flex justiy-content-center align-items-center ms-3">
                                        <i class="fas fa-phone-volume fs-3x"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Engage widget 1-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-4 pe-xl-12">
                <!--begin::Misc Widget 1-->
                <div class="row mb-5 g-5 g-xl-8">
                    <div class="col-6">
                        <div class="card card-stretch">
                            <span
                                id="new-activity" 
                                class="btn btn-flex btn-icon-gray-600 flex-column align-items-center w-100 p-10 bg-light-primary hoverable border border-primary">
                                <!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
                                <span class="mb-3">
                                    <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs026.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M7 20.5L2 17.6V11.8L7 8.90002L12 11.8V17.6L7 20.5ZM21 20.8V18.5L19 17.3L17 18.5V20.8L19 22L21 20.8Z" fill="black"/>
                                        <path d="M22 14.1V6L15 2L8 6V14.1L15 18.2L22 14.1Z" fill="black"/>
                                        </svg>
                                    </span>
                                     <!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                                <span class="fs-4 fw-bolder text-gray-600">AKTİVİTE</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-stretch">
                            <span 
                                id="new-consumer"
                                class="btn btn-flex btn-icon-gray-600 flex-column align-items-center w-100 p-10 bg-light-success hoverable border border-success">
                                <!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
                                <span class="mb-3">
                                    <!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com013.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black"/>
                                        <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black"/>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                                <span class="fs-4 fw-bolder text-gray-600">YENİ MÜŞTERİ</span>
                            </span>
                        </div>
                    </div>
                </div>
                <!--end::Misc Widget 1-->
                <!--begin::Alert-->
                <div class="alert alert-dismissible bg-light-info border border-info border-dashed border-3 d-flex align-items-center p-5 mb-10">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-info me-4 mb-5 mb-sm-0">
                        <i class="fas fa-bell text-info"></i>
                    </span>
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <!--begin::Content-->
                        <span class="alert-consumer-info-text">Henüz bir müşteri seçimi yapmadınız.</span>
                        <!--end::Content-->

                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Alert-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        
        @include('cm.self-section.consumer-content')
        @section('extra_content')
            @include('cm.self-section.consumers-drawer')
            @include('cm.self-section.floating-menu')

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
            
            <!--begin::Aktivity Add Modal-->
            <div class="modal fade" tabindex="-1" id="add_activity_modal">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="title-content">
                                <h3 class="modal-title d-inline-block me-5">Aktivite Oluştur</h3>
                                <span class="modal-title-consumer-info text-muted"></span>
                            </div>
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
                            <form method="POST" id="add_activity_form">
                                @csrf
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <!--begin::Radio group-->
                                    <div class="d-inline-flex" data-kt-buttons="true">
                                        <!--begin::Radio button-->
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary px-4 py-3 me-2 active">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid form-check-primary me-4">
                                                    <input class="form-check-input" type="radio" name="activity_direction" value="inbound" checked required/>
                                                </div>
                                                <!--end::Radio-->
                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center m-0 fs-5 text-gray-700 fw-bold flex-wrap">
                                                        GELEN
                                                    </h2>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        <!--end::Radio button-->
                                        <!--begin::Radio button-->
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary px-4 py-3">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid form-check-primary me-4">
                                                    <input class="form-check-input" type="radio" name="activity_direction" value="outbound" required/>
                                                </div>
                                                <!--end::Radio-->
                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center m-0 fs-5 text-gray-700 fw-bold flex-wrap">
                                                        GİDEN
                                                    </h2>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        <!--end::Radio button-->
                                    </div>
                                    <!--end::Radio group-->
                                    <div class="d-inline-flex">
                                        <div class="col-lg-3 text-center mt-2">
                                            <input type="radio" class="btn-check" name="activity_sense" id="add_activity_sense_1" value="1" required>
                                            <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="add_activity_sense_1">
                                                <i class="far fa-smile-beam fs-3x text-success ms-1"></i>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 text-center mt-2">
                                            <input type="radio" class="btn-check" name="activity_sense" id="add_activity_sense_2" value="2" required>
                                            <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="add_activity_sense_2">
                                                <i class="far fa-meh fs-3x text-muted ms-1"></i>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 text-center mt-2">
                                            <input type="radio" class="btn-check" name="activity_sense" id="add_activity_sense_3" value="3" required>
                                            <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="add_activity_sense_3">
                                                <i class="far fa-frown-open fs-3x text-dark ms-1"></i>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 text-center mt-2">
                                            <input type="radio" class="btn-check" name="activity_sense" id="add_activity_sense_4" value="4" required>
                                            <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="add_activity_sense_4">
                                                <i class="far fa-angry fs-3x text-danger ms-1"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-inline-flex w-200px">
                                        <input type="text" name="order_number" class="form-control form-control-solid" placeholder="Sipariş No(Opsiyonel)" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <div class="form-control w-50 me-4">
                                        <select name="activity_subject" class="form-select form-select-solid" required>
                                            <option value="">Çağrı Konusu Seçin</option>
                                            @foreach ($subjects as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>                                  
                                    </div>
                                    <div class="form-control w-50 ms-4">
                                        <select name="activity_channel" class="form-select form-select-solid" required>
                                            <option value="">Çağrı Kanalı Seçin</option>
                                            @foreach ($activityChannels as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == 1 ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>                                  
                                    </div>
                                </div>
                                <div class="row mb-5 mx-0 py-3 border rounded">
                                    <div class="col-lg-4">
                                        <select name="case" class="form-select form-select-solid" required>
                                            <option value="">Aktivite tipi seçiniz</option>
                                            @foreach ($cases as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 subcase-content"></div>
                                    <div class="col-lg-4 activity-case-content"></div>
                                </div>
                                <!--begin::Input group-->
                                <div class="input-group input-group-solid mb-5">
                                    <textarea name="activity_note" class="form-control" aria-label="With textarea" rows="4" required></textarea>
                                </div>
                                <!--end::Input group-->
                                <div class="d-flex">
                                    <div class="d-flex flex-column justify-content-between w-lg-50 pe-5">
                                        <!--begin::Input group-->
                                        <div class="d-flex flex-stack mb-3">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <label class="fs-6 fw-semibold form-label">Yönelendirme yapacak mısınız?</label>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" name="add_assignment" type="checkbox"/>
                                                <span class="form-check-label fw-semibold text-muted">
                                                    Yönlendir
                                                </span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Input group-->
                                        <select name="assigned_user" class="form-select form-select-solid activity-assignment-field d-none" required>
                                            <option value="">Yönlendirilecek kişi</option>
                                            @foreach ($users as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-lg-50">
                                        <!--begin::Input group-->
                                        <div class="input-group input-group-solid">
                                            <textarea 
                                                name="assignment_note" 
                                                class="form-control activity-assignment-field d-none" 
                                                placeholder="Yönlendirme notu"
                                                rows="4" required></textarea>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                            </form>
                        </div>
            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                            <button type="button" class="btn btn-primary text-gray-200" id="add_activity_form_button_2">
                                <span class="indicator-label">
                                    KAYDET KAPAT
                                </span>
                                <span class="indicator-progress">
                                    Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-info" id="add_activity_form_button">
                                <span class="indicator-label">
                                    KAYDET
                                </span>
                                <span class="indicator-progress">
                                    Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Aktivity Add Modal-->
            
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
        @endsection
    </div>
    <!--end::Container-->
@endsection

@section('footer_scripts')
    @include('cm.self-section.footer-scripts')
@endsection