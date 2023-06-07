
<!--begin::Container-->
<div class="container-xxl pt-14" id="ajax_dynamic_content">
    <!--begin::AjaxContent-->
    <div class="ajax-content">
        <!--begin::Card body-->
        <div class="card-body p-0">
            <!--begin::Illustration-->
            <div class="text-center px-4 pt-20">
                <img class="mw-100 mh-300px" alt="" src="{{ asset('assets/media/illustrations/sigma-1/2.png') }}" />
            </div>
            <!--end::Illustration-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::AjaxContent-->
</div>
<!--end::Container-->

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
    <div class="d-flex justify-content-center align-items-center w-100 h-100 mini-spinner">
        <div class="spinner-grow text-secondary mx-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary mx-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary mx-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<!--begin::Spinner template-->
   
<!--begin::Container-->
<div class="container-xxl pt-14 d-none" id="consumer_profile_template">
    <!--begin::Layout-->
    <div class="consumer-profile d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Connected Accounts-->
            <div 
                class="consumer-sticky card mb-5 mb-xl-8"
                data-kt-sticky="true"
                data-kt-sticky-name="consumer-profile-sticky"
                data-kt-sticky-offset="{default: false, xl: '350px'}"
                data-kt-sticky-width="{lg: '250px', xl: '350px'}"
                data-kt-sticky-left="auto"
                data-kt-sticky-top="100px"
                data-kt-sticky-animation="false"
                data-kt-sticky-zindex="95">
                <!--begin::Card header-->
                <div
                    {{-- style="background: linear-gradient(312.14deg, #00D2FF 0%, #3A7BD5 100%)"  --}}
                    class="card-header border-0 px-0 overflow-hidden ribbon ribbon-top">
                    <div class="ribbon-label bg-light-info bg-hover-opacity-25 border border-info text-info" role="button">
                        <i class="bi bi-person-lines-fill fs-2x text-info"></i>
                    </div>
                    <!--begin::Ribbon-->
                    <div class="ribbon ribbon-triangle ribbon-top-start border-primary">
                        <!--begin::Ribbon icon-->
                        <div class="ribbon-icon mt-n5 ms-n6">
                            <i class="bi bi-pin-angle fs-2 text-white"></i>
                        </div>
                        <!--end::Ribbon icon-->
                    </div>
                    <!--end::Ribbon-->
                    <!--begin::Notice-->
                    <div class="notice d-flex w-100 px-6 pb-0 pt-18">
                        <!--begin::Icon-->
                        <div class="rounded-circle m-0 p-0 bg-secondary border border-info border-2 w-70px h-70px me-4">
                            <img src="{{ asset('assets/media/svg/illustrations/cm-consumer.svg') }}" width="70" alt="profile-placeholder">
                        </div>
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-semibold">
                                <div class="fs-6 text-dark">
                                    <strong class="d-block fs-3">[[consumername]]</strong>
                                    <span class="d-block">[[consumerphone]]</span>
                                    <small class="d-block">[[consumermail]]</small>
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
                                                        value="[[consumerfirstname]]" 
                                                        required/>
                                                    <input 
                                                        type="text" 
                                                        name="lastName" 
                                                        class="form-control form-control-solid ms-2" 
                                                        placeholder="Soyisim" 
                                                        value="[[consumerlastname]]" 
                                                        required/>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="text-gray-600" for="update_consumer_phone">Telefon <span class="required"></span></label>
                                                    <input type="text" 
                                                        name="phone"
                                                        class="form-control form-control-solid"
                                                        id="update_consumer_phone"
                                                        placeholder="(___) ___-____"
                                                        value="[[consumerphone]]"
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
                                            <button type="button" class="btn btn-primary" id="update_consumer_form_button" data-consumer-id="[[consumerID]]">
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
                    </div>
                    <!--end::Notice-->
                </div>
                <!--end::Card header-->
                <!--end::Item-->
                <div class="separator border-secondary border-5 rounded w-50 mx-auto mt-12 mb-16"></div>
                <!--begin::Item-->
                <!--begin::Card body-->
                <div class="card-body pt-0 px-0">
                    <!--begin::Underline-->
                    <span class="d-inline-block position-relative ms-5">
                        <!--begin::Label-->
                        <span class="d-inline-block mb-4 fs-2 fw-bold">
                            Aktiviteler
                        </span>
                        <!--end::Label-->
                        <!--begin::Line-->
                        <span class="d-inline-block position-absolute h-6px bottom-0 end-0 start-0 bg-info translate rounded mb-3"></span>
                        <!--end::Line-->
                    </span>
                    <!--end::Underline-->
                    <!--begin::Items-->
                    <div class="pb-2 activities-content">
                        
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer border-0 d-flex justify-content-center pt-0">
                    <button 
                        class="btn btn-sm btn-light-dark px-10 border border-dark" 
                        id="consumer_all_activities_button" 
                        data-consumer-id="[[consumerID]]">
                        <span class="indicator-label">
                            Tüm Aktiviteler
                        </span>
                        <span class="indicator-progress">
                            Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Connected Accounts-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15" id="consumer_activity_tab_contet">
            <div class="card h-550px">
                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                    <span class="h1">Aktivite Detayları</span>
                    <span class="fs-3 text-muted mb-10">Detaylarını görmek için sol taraftan bir aktivite seçin.</span>
                    <img src="{{ asset('assets/media/svg/illustrations/activity.svg') }}" class="img-fluid w-300px" alt="">
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->
</div>
<!--end::Container-->

<!--begin::Modal - Update Ativity-->
<div class="modal fade" id="activity_update_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="activity_update_modal_form">
                @csrf
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Aktivite Güncelle</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body">
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="button" id="activity_update_modal_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">
                        Vazgeç
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="activity_update_modal_form_submit" class="btn btn-primary">
                        <span class="indicator-label">Güncelle</span>
                        <span class="indicator-progress">Lütfen bekleyin... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Update Ativity-->

<!--begin::Update Ativity Modal Template-->
<div id="activity_update_modal_template" class="d-none">
    <div class="fields">
        <input type="hidden" name="activity_id">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <!--begin::Radio group-->
            <div class="d-inline-flex me-3" data-kt-buttons="true">
                <!--begin::Radio button-->
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary px-4 py-3 me-2 inbound-radio-label">
                    <!--end::Description-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Radio-->
                        <div class="form-check form-check-custom form-check-solid form-check-primary me-4">
                            <input class="form-check-input inbound-radio" type="radio" name="activity_direction" value="inbound" required/>
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
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary px-4 py-3 outbound-radio-label">
                    <!--end::Description-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Radio-->
                        <div class="form-check form-check-custom form-check-solid form-check-primary me-4">
                            <input class="form-check-input outbound-radio" type="radio" name="activity_direction" value="outbound" required/>
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
            <!--::Radio group-->
            <div class="d-inline-flex">
                <div class="col-lg-3 text-center mt-2">
                    <input type="radio" class="btn-check" name="activity_sense" id="hissiyat_1" value="1" required>
                    <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="hissiyat_1">
                        <i class="far fa-smile-beam fs-3x text-success ms-1"></i>
                    </label>
                </div>
                <div class="col-lg-3 text-center mt-2">
                    <input type="radio" class="btn-check" name="activity_sense" id="hissiyat_2" value="2" required>
                    <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="hissiyat_2">
                        <i class="far fa-meh fs-3x text-muted ms-1"></i>
                    </label>
                </div>
                <div class="col-lg-3 text-center mt-2">
                    <input type="radio" class="btn-check" name="activity_sense" id="hissiyat_3" value="3" required>
                    <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="hissiyat_3">
                        <i class="far fa-frown-open fs-3x text-dark ms-1"></i>
                    </label>
                </div>
                <div class="col-lg-3 text-center mt-2">
                    <input type="radio" class="btn-check" name="activity_sense" id="hissiyat_4" value="4" required>
                    <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="hissiyat_4">
                        <i class="far fa-angry fs-3x text-danger ms-1"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="w-50 me-2">
                <select name="activity_subject" class="form-select form-select-solid" aria-label="Select example" required>
                    <option value="">Çağrı Konusu Seçiniz...</option>
                    @foreach ($subjects as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>                                    
            </div>
            <div class="w-50 ms-2">
                <select name="activity_channel" class="form-select form-select-solid" aria-label="Select example" required>
                    <option value="">Çağrı Kanalı Seçiniz...</option>
                    @foreach ($activityChannels as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
                </select>                                    
            </div>
        </div>
        <!--begin::Input group-->
        <div class="input-group input-group-solid">
            <textarea name="activity_note" class="form-control" aria-label="With textarea" rows="4" required></textarea>
        </div>
        <!--end::Input group-->
    </div>
</div>
<!--end::Update Ativity Modal Template-->

<!--begin::ConsumerTabContent Template-->
<div id="cosumer_tab_content_template" class="d-none">
    <div class="activity-detail-template">
        <!--begin:::Tabs-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-dark text-active-primary pb-4 active" data-bs-toggle="tab" href="#consumer_activity_tab">
                    <i class="fas fa-chart-line"></i> Aktivite Detayı
                </a>
            </li>
            <!--end:::Tab item-->
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-dark text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#consumer_activity_calls">
                    <i class="fas fa-headset"></i> Çağrılar
                </a>
            </li>
            <!--end:::Tab item-->
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-dark text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#consumer_activity_redirects">
                    <i class="fas fa-map-signs"></i> Yönlendirmeler
                </a>
            </li>
            <!--end:::Tab item-->
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-dark text-active-primary pb-4" data-bs-toggle="tab" href="#consumer_activity_logs">
                    <i class="fas fa-list"></i> Logs
                </a>
            </li>
            <!--end:::Tab item-->
            <!--begin:::Tab item-->
            <li class="nav-item ms-auto">
                <!--begin::Action menu-->
                <button type="button" class="btn btn-info [[formDisabled]]" id="activity_completed_button" data-activity-id="[[activityID]]">
                    <small>Aktiviteyi Kapat</small>
                </button>
                <!--end::Menu-->
            </li>
            <!--end:::Tab item-->
        </ul>
        <!--end:::Tabs-->
        <!--begin:::Tab content-->
        <div class="tab-content" id="myTabContent">
            <!--begin:::Tab pane-->
            <div class="tab-pane fade show active" id="consumer_activity_tab" role="tabpanel">
                <!--begin::details View-->
                <div class="card pt-4 mb-6 mb-xl-9" id="consumer_activity_detail">
                    <div class="card-header align-items-center border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Aktivite Bilgileri [[activityItemIcon]]</h2>
                        </div>
                        <!--end::Card title-->
                        <span 
                            class="btn btn-icon btn-flex btn-active-light-primary w-40px h-40px [[formDisabled]]" 
                            data-activity-id="[[activityID]]"
                            data-bs-toggle="modal" 
                            data-bs-target="#activity_update_modal">
                            <i class="fas fa-pencil-alt fs-2"></i>
                        </span>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Aktvite ID</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">
                                    <div class="fs-6 fw-semibold text-dark">
                                        #[[activityID]]
                                    </div>
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Oluşturan Agent</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">
                                    <div class="fs-6 fw-semibold text-info">
                                        <span class="badge badge-light-info">[[ActivityAgent]]</span>
                                    </div>
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Oluşturulma Tarihi</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <i class="far fa-calendar"></i> [[activityDate]] <i class="far fa-clock"></i> [[activityTime]]
                                    </div>
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Aktivite Yönü</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">[[activityDirection]]</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Aktivite Kanalı</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">[[activityChannel]]</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Aktivite Tipi</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="badge badge-success">[[activityCase]]</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Aktivite Konusu</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-semibold fs-6 text-gray-800 text-hover-primary">[[activitySubject]]</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Aktivite Hissiyatı</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                [[activitySenseIcon]]
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-info rounded border-info border border-dashed p-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                            <span class="svg-icon svg-icon-2tx svg-icon-info me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">Aktivite Özeti</h4>
                                    <div class="fs-6 text-gray-700">
                                        [[activityNote]]
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>
            <!--end:::Tab pane-->
            <!--begin:::Tab pane-->
            <div class="tab-pane fade show" id="consumer_activity_calls" role="tabpanel">
                <!--begin::Timeline-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Çağrı Geçmişi</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Timeline-->
                        <div class="timeline activity-calls-content">
                            <!--Aktivite Çağrıları-->
                        </div>
                        <!--end::Timeline-->
                    </div>
                    <!--end::Card body-->
                    <!--end::separator-->
                    {{-- <div class="separator border-secondary border-3 rounded w-75 mx-auto mb-0"></div> --}}
                    <!--begin::separator-->
                    <!--begin::Card footer-->
                    <div class="card-footer border-0 [[formDisabled]]">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-7">
                            <!--begin::Label-->
                            <span class="d-inline-block mb-2 fs-2 fw-bold">
                                Çağrı Ekle
                            </span>
                            <!--end::Label-->
                            <!--begin::Line-->
                            <span class="d-inline-block position-absolute h-6px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                            <!--end::Line-->
                        </span>
                        <!--end::Underline-->
                        <form method="POST" class="form-control" id="add_call_form">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <!--begin::Radio group-->
                                <div class="d-inline-flex me-3" data-kt-buttons="true">
                                    <!--begin::Radio button-->
                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary px-4 py-3 me-2">
                                        <!--end::Description-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Radio-->
                                            <div class="form-check form-check-custom form-check-solid form-check-primary me-4">
                                                <input class="form-check-input" type="radio" name="call_direction" value="inbound" required/>
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
                                                <input class="form-check-input" type="radio" name="call_direction" value="outbound" required/>
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
                                        <input type="radio" class="btn-check" name="call_sense" id="call_sense_1" value="1" required>
                                        <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="call_sense_1">
                                            <i class="far fa-smile-beam fs-3x text-success ms-1"></i>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 text-center mt-2">
                                        <input type="radio" class="btn-check" name="call_sense" id="call_sense_2" value="2" required>
                                        <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="call_sense_2">
                                            <i class="far fa-meh fs-3x text-muted ms-1"></i>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 text-center mt-2">
                                        <input type="radio" class="btn-check" name="call_sense" id="call_sense_3" value="3" required>
                                        <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="call_sense_3">
                                            <i class="far fa-frown-open fs-3x text-dark ms-1"></i>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 text-center mt-2">
                                        <input type="radio" class="btn-check" name="call_sense" id="call_sense_4" value="4" required>
                                        <label class="btn btn-active-secondary w-50px h-50px d-flex justify-content-center align-items-center rounded-circle" for="call_sense_4">
                                            <i class="far fa-angry fs-3x text-danger ms-1"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-control w-250px">
                                    <select name="call_channel" class="form-select form-select-solid" aria-label="Select example" required>
                                        <option value="">Çağrı Kanalı Seçiniz...</option>
                                        @foreach ($activityChannels as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <!--begin::Input group-->
                            <div class="input-group input-group-solid">
                                <textarea name="call_note" class="form-control" aria-label="With textarea" rows="4" required></textarea>
                            </div>
                            <!--end::Input group-->
                            <div class="d-flex justify-content-between align-items-center my-4">
                                <input 
                                    type="text" 
                                    name="call_different_caller" 
                                    class="form-control form-control-solid w-lg-50" 
                                    placeholder="Arayan kişi farklı ise doldurunuz"
                                    required/>
                                <button type="button" class="btn btn-info px-12" id="add_call_form_button" data-activity-id="[[activityID]]">
                                    <span class="indicator-label">
                                        KAYDET
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Timeline-->
            </div>
            <!--end:::Tab pane-->
            <!--begin:::Tab pane-->
            <div class="tab-pane fade" id="consumer_activity_redirects" role="tabpanel">
                <!--begin::List Widget 3-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Yönlendirmeler</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body activity-assignments-content pt-2">
                        <!--Aktivite Yönlendirmeleri-->
                    </div>
                    <!--end::Body-->
                    <!--begin::Card footer-->
                    <div class="card-footer border-0 [[formDisabled]]">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-7">
                            <!--begin::Label-->
                            <span class="d-inline-block mb-2 fs-2 fw-bold">
                                Yönlendir
                            </span>
                            <!--end::Label-->
                            <!--begin::Line-->
                            <span class="d-inline-block position-absolute h-6px bottom-0 end-0 start-0 bg-warning translate rounded"></span>
                            <!--end::Line-->
                        </span>
                        <!--end::Underline-->
                        <form method="POST" class="form-control" id="add_assignment_form">
                            @csrf
                            <!--begin::Input group-->
                            <span class="text-muted ms-1">Yönlendirme Notu</span>
                            <div class="input-group input-group-solid">
                                <textarea name="assignment_note" class="form-control" rows="4" required></textarea>
                            </div>
                            <!--end::Input group-->
                            <div class="d-flex justify-content-between align-items-center my-4">
                                <div class="form-control w-300px">
                                    <select name="assigned_user" class="form-select form-select-solid" aria-label="Select example" required>
                                        <option value="">Kime Yönlendireceksiniz...</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                                <button type="button" class="btn btn-info px-12" id="add_assignment_form_button" data-activity-id="[[activityID]]">
                                    <span class="indicator-label">
                                        KAYDET
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end:List Widget 3-->
            </div>
            <!--end:::Tab pane-->
            <!--begin:::Tab pane-->
            <div class="tab-pane fade" id="consumer_activity_logs" role="tabpanel">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Logs</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-0">
                        <!--begin::Table wrapper-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table 
                                class="table align-middle table-row-dashed fw-bold text-gray-600 fs-6 gy-5 activity-logs-content">
                                <!--begin::Table body-->
                                <tbody>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table wrapper-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end:::Tab pane-->
        </div>
        <!--end:::Tab content-->
    </div>
</div>

<!--begin::Activity Assignment Item Template-->
<div id="activity_assignmetn_item_template" class="d-none">
    <!--begin::Item-->
    <div class="assignment-item-template d-flex align-items-start mb-16">
        <!--begin::Bullet-->
        <span class="bullet bullet-vertical h-50px bg-primary"></span>
        <!--end::Bullet-->
        <!--begin::Icon-->
        <span class="w-40px h-50px d-flex justify-content-center align-items-center">
            <i class="fas fa-reply fs-2x text-primary"></i>
        </span>
        <!--end::Icon-->
        <!--begin::Description-->
        <div class="w-100 ms-2">
            <div class="d-flex justify-content-between mb-3">
                <div class="text-muted">
                    <i class="far fa-calendar"></i> [[assignmentDate]] <i class="far fa-clock"></i> [[assignmentTime]]
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge badge-light-success fs-8 fw-bolder">[[assignmentFromUser]]</span>
                    <i class="fas fa-long-arrow-alt-right fs-2x text-muted"></i>
                    <span class="badge badge-light-info fs-8 fw-bolder">[[assignmentToUser]]</span>
                </div>
            </div>
            <span class="text-muted fw-bold d-block rounded border border-dashed border-dark p-5 bg-light">
                [[assignmentNote]]
            </span>
        </div>
        <!--end::Description-->
    </div>
    <!--end:Item-->
    <!--begin::Item-->
    <div class="d-flex align-items-start mb-16">
        <!--begin::Bullet-->
        <span class="bullet bullet-vertical h-50px bg-success"></span>
        <!--end::Bullet-->
        <!--begin::Icon-->
        <span class="w-40px h-50px d-flex justify-content-center align-items-center">
            <i class="fas fa-reply fs-2x text-success"></i>
        </span>
        <!--end::Icon-->
        <!--begin::Description-->
        <div class="w-100 ms-2">
            <div class="d-flex justify-content-between mb-3">
                <div class="text-muted">
                    <i class="far fa-calendar"></i> 2022 08 25 <i class="far fa-clock"></i> 15:53
                </div>
                <span class="badge badge-light-success fs-8 fw-bolder">Uğur Öksüz</span>
            </div>
            <span class="text-muted fw-bold d-block rounded border border-dashed border-dark p-5 bg-light">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Beatae.
            </span>
        </div>
        <!--end::Description-->
    </div>
    <!--end:Item-->
</div>
<!--end::Activity Assignment Item Template-->

<!--begin::ItemSense-->
<div id="activity_calls_template" class="d-none">
    <!--begin::Timeline item-->
    <div class="timeline-item timeline-item-template">
        <!--begin::Timeline line-->
        <div class="timeline-line w-40px"></div>
        <!--end::Timeline line-->
        <!--begin::Timeline icon-->
        <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
            [[callIcon]]
        </div>
        <!--end::Timeline icon-->
        <!--begin::Timeline content-->
        <div class="timeline-content mb-10 mt-n1">
            <!--begin::Timeline heading-->
            <div class="d-flex justify-content-between align-items-center pe-3 mb-5">
                <!--begin::Description-->
                <div class="d-flex align-items-center mt-1 fs-6">
                    <!--begin::Info-->
                    <div class="text-muted me-2 fs-7">
                        <i class="far fa-calendar"></i> [[callDate]] <i class="far fa-clock"></i> [[callTime]] 
                        <i class="fas fa-headset"></i> [[callAgent]]
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Description-->
                <div class="d-flex align-items-center">
                    <smal class="text-muted fw-semibold fs-8 me-3">[[callDirection]]</smal>
                    <span class="badge badge-light-info me-3">[[callChannel]]</span>
                    [[callSenseIcon]]
                </div>
            </div>
            <!--end::Timeline heading-->
            <!--begin::Timeline details-->
            <div class="overflow-auto pb-5">
                <!--begin::Record-->
                <div class="d-flex align-items-center bg-light border border-dashed border-dark text-gray-700 rounded min-w-750px px-7 py-5 mb-0">
                    [[callNote]]
                </div>
                <!--end::Record-->
                [[callerDifferent]]
            </div>
            <!--end::Timeline details-->
        </div>
        <!--end::Timeline content-->
    </div>
    <!--end::Timeline item-->

    <!--begin::Timeline Sense Icon-->
    <div id="call_sense_icon_templates">
        <i class="icon-1 far fa-smile-beam fa-2x text-success"></i>
        <i class="icon-2 far fa-meh fa-2x text-muted"></i>
        <i class="icon-3 far fa-frown-open fa-2x text-dark"></i>
        <i class="icon-4 far fa-angry fa-2x text-danger"></i>
    </div>
    <!--end::Timeline Sense Icon-->

    <!--end::Timeline Call Icon-->
    <div id="call_icon_templates">
        <div class="inbound-call-icon symbol-label bg-light-success">
            <!--begin::Svg Icon-->
            <span class="svg-icon svg-icon-2 svg-icon-2hx svg-icon-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <path d="M9.8604543,6.01162174 C9.94073619,5.93133984 10.0459506,5.88077119 10.1587919,5.86823326 C10.4332453,5.83773844 10.6804547,6.03550595 10.7109496,6.30995936 L11.2341533,11.0187935 C11.2382309,11.0554911 11.2382309,11.0925274 11.2341533,11.129225 C11.2036585,11.4036784 10.9564491,11.6014459 10.6819957,11.5709511 L5.97316161,11.0477473 C5.86032028,11.0352094 5.75510588,10.9846407 5.67482399,10.9043588 C5.47956184,10.7090967 5.47956184,10.3925142 5.67482399,10.197252 L7.06053236,8.81154367 L5.55907018,7.31008149 C5.36380803,7.11481935 5.36380803,6.79823686 5.55907018,6.60297471 L6.26617696,5.89586793 C6.46143911,5.70060578 6.7780216,5.70060578 6.97328374,5.89586793 L8.47474592,7.39733011 L9.8604543,6.01162174 Z" style="fill: #464646 !important;opacity: 1;"></path>
                    <path d="M12.0799676,14.7839934 L14.2839934,12.5799676 C14.8927139,11.9712471 15.0436229,11.0413042 14.6586342,10.2713269 L14.5337539,10.0215663 C14.1487653,9.25158901 14.2996742,8.3216461 14.9083948,7.71292558 L17.6411989,4.98012149 C17.836461,4.78485934 18.1530435,4.78485934 18.3483056,4.98012149 C18.3863063,5.01812215 18.4179321,5.06200062 18.4419658,5.11006808 L19.5459415,7.31801948 C20.3904962,9.0071287 20.0594452,11.0471565 18.7240871,12.3825146 L12.7252616,18.3813401 C11.2717221,19.8348796 9.12170075,20.3424308 7.17157288,19.6923882 L4.75709327,18.8875616 C4.49512161,18.8002377 4.35354162,18.5170777 4.4408655,18.2551061 C4.46541191,18.1814669 4.50676633,18.114554 4.56165376,18.0596666 L7.21292558,15.4083948 C7.8216461,14.7996742 8.75158901,14.6487653 9.52156634,15.0337539 L9.77132688,15.1586342 C10.5413042,15.5436229 11.4712471,15.3927139 12.0799676,14.7839934 Z" fill="#000000"></path>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <div class="outbound-call-icon symbol-label bg-light-primary">
            <!--begin::Svg Icon-->
            <span class="svg-icon svg-icon-2 svg-icon-2hx svg-icon-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <path d="M7.14296018,11.6653622 C7.06267828,11.7456441 6.95746388,11.7962128 6.84462255,11.8087507 C6.57016914,11.8392455 6.32295974,11.641478 6.29246492,11.3670246 L5.76926113,6.65819047 C5.76518362,6.62149288 5.76518362,6.58445654 5.76926113,6.54775895 C5.79975595,6.27330553 6.04696535,6.07553802 6.32141876,6.10603284 L11.0302529,6.62923663 C11.1430942,6.64177456 11.2483086,6.69234321 11.3285905,6.77262511 C11.5238526,6.96788726 11.5238526,7.28446974 11.3285905,7.47973189 L9.94288211,8.86544026 L11.4443443,10.3669024 C11.6396064,10.5621646 11.6396064,10.8787471 11.4443443,11.0740092 L10.7372375,11.781116 C10.5419754,11.9763782 10.2253929,11.9763782 10.0301307,11.781116 L8.52866855,10.2796538 L7.14296018,11.6653622 Z" style="fill: #464646 !important;opacity: 1;"></path>
                    <path d="M12.0799676,14.7839934 L14.2839934,12.5799676 C14.8927139,11.9712471 15.0436229,11.0413042 14.6586342,10.2713269 L14.5337539,10.0215663 C14.1487653,9.25158901 14.2996742,8.3216461 14.9083948,7.71292558 L17.6411989,4.98012149 C17.836461,4.78485934 18.1530435,4.78485934 18.3483056,4.98012149 C18.3863063,5.01812215 18.4179321,5.06200062 18.4419658,5.11006808 L19.5459415,7.31801948 C20.3904962,9.0071287 20.0594452,11.0471565 18.7240871,12.3825146 L12.7252616,18.3813401 C11.2717221,19.8348796 9.12170075,20.3424308 7.17157288,19.6923882 L4.75709327,18.8875616 C4.49512161,18.8002377 4.35354162,18.5170777 4.4408655,18.2551061 C4.46541191,18.1814669 4.50676633,18.114554 4.56165376,18.0596666 L7.21292558,15.4083948 C7.8216461,14.7996742 8.75158901,14.6487653 9.52156634,15.0337539 L9.77132688,15.1586342 C10.5413042,15.5436229 11.4712471,15.3927139 12.0799676,14.7839934 Z" fill="#000000"></path>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
    </div>
    <!--end::Timeline Call Icon-->

    <!--begin::Different Caller-->
    <div id="caller_different_template">
         <!--begin::Alert-->
         <div class="caller-different alert alert-light bg-light border border-secondary d-flex align-items-center w-500px px-5 py-2 mt-3">
            <!--begin::Icon-->
            <i class="fas fa-user-circle fs-2x me-4"></i>
            <!--end::Icon-->
            <div class="d-flex justify-content-between w-100">
                <!--begin::Content-->
                <span>
                    <span class="text-dark me-4">[[callerDifferentText]]</span>
                    <!--<span class="text-gray-700">(544) 419 5111</span>-->
                </span>
                <span class="badge badge-secondary">Arayan Kişi Farklı</span>
                <!--end::Content-->
            </div>
        </div>
        <!--end::Alert-->
    </div>
    <!--end::Different Caller-->
</div>
<!--begin::ItemSense-->

<!--begin::ItemSense-->
<div id="activity_sense_big_icon_templates" class="d-none">
    <div class="activity-sense-1">
        <i class="far fa-smile-beam fa-4x text-success"></i>
    </div>
    <div class="activity-sense-2">
        <i class="far fa-meh fa-4x text-muted"></i>
    </div>
    <div class="activity-sense-3">
        <i class="far fa-frown-open fa-4x text-dark"></i>
    </div>
    <div class="activity-sense-4">
        <i class="far fa-angry fa-4x text-danger"></i>
    </div>
</div>
<!--end::ItemSense-->
<!--end::ConsumerTabContent Template-->


<!--begin::Consumer Activity Item Template-->
<div id="activity-item-template" class="d-none">
    <!--begin::Item-->
    <div class="activity-item d-flex flex-stack">
        <div class="clickable d-flex w-100 bg-hover-light p-5" data-activity-id="[[activityID]]">
            <!--begin::Svg Icon-->
            [[activityIcon]]
            <!--end::Svg Icon-->
            <div class="d-flex w-100 flex-column">
                <div class="d-flex justify-content-between">
                    <small class="fs-6 text-dark">[[activityCase]]</small>
                    <span class="badge badge-light-dark">[[activityChannel]]</span>
                </div>
                <div class="text-end">
                    <small class="text-muted me-1">[[activitySubject]]</small>
                </div>
                <div class="fs-6 fw-semibold text-muted">
                    <i class="far fa-calendar"></i> [[activityDate]] <i class="far fa-clock"></i> [[activityTime]]
                </div>
                <div class="position-relative h-10px">
                    [[activitySenseIcon]]
                </div>
            </div>
        </div>
    </div>
    <!--end::Item-->
    <!--begin::ItemIcon-->
    <div class="continuing-icon">
        <span class="svg-icon svg-icon-warning svg-icon-2hx me-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                <rect x="11" y="17" width="7" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                <rect x="11" y="9" width="2" height="2" rx="1" transform="rotate(-90 11 9)" fill="currentColor"/>
            </svg>
        </span>
    </div>
    <div class="completed-icon">
        <span class="svg-icon svg-icon-success svg-icon-2hx me-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 
                2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 
                16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 
                21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 
                21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 
                21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"/>
            </svg>
        </span>
    </div>
    <!--end::ItemIcon-->
    <!--begin::EmptyResult-->
    <div class="empty-result d-flex flex-column justify-content-center align-items-center p-5">
        <i class="fas fa-search-minus fs-5x text-gray-300 mb-4"></i>
        <span class="text-muted">Henüz Aktivite Eklenmemiş</span>
    </div>
    <!--end::EmptyResult-->
    <!--begin::ItemSense-->
    <div id="activity-sense-icon">
        <div class="activity-sense-1">
            <i class="far fa-smile-beam fa-2x text-success position-absolute bottom-0 end-0"></i>
        </div>
        <div class="activity-sense-2">
            <i class="far fa-meh fa-2x text-muted position-absolute bottom-0 end-0"></i>
        </div>
        <div class="activity-sense-3">
            <i class="far fa-frown-open fa-2x text-dark position-absolute bottom-0 end-0"></i>
        </div>
        <div class="activity-sense-4">
            <i class="far fa-angry fa-2x text-danger position-absolute bottom-0 end-0"></i>
        </div>
    </div>
    <!--end::ItemSense-->

    <!--end::ItemIcon-->
    <div class="separator separator-dashed border-secondary mx-5"></div>
    <!--end::ItemIcon-->
</div>
<!--end::Consumer Activity Item Template-->

<div id="activity_logs_item_template" class="d-none">
    <table>
        <tbody>
            <!--begin::Table row-->
            <tr class="start-log-item">
                <!--begin::Badge=-->
                <td class="min-w-70px">
                    <div class="badge badge-light-dark">START</div>
                </td>
                <!--end::Badge=-->
                <!--begin::Status=-->
                <td>
                    <small>[[logNote]]</small>
                </td>
                <!--end::Status=-->
                <!--begin::Timestamp=-->
                <td class="pe-0 text-end min-w-200px text-muted fs-7">
                        <i class="far fa-calendar"></i> [[logDate]] <i class="far fa-clock"></i> [[logTime]]
                </td>
                <!--end::Timestamp=-->
            </tr>
            <!--end::Table row-->
            <!--begin::Table row-->
            <tr class="call-log-item">
                <!--begin::Badge=-->
                <td class="min-w-70px">
                    <div class="badge badge-light-success">ÇAĞRI</div>
                </td>
                <!--end::Badge=-->
                <!--begin::Status=-->
                <td>
                    <small>[[logNote]]</small>
                </td>
                <!--end::Status=-->
                <!--begin::Timestamp=-->
                <td class="pe-0 text-end min-w-200px text-muted fs-7">
                        <i class="far fa-calendar"></i> [[logDate]] <i class="far fa-clock"></i> [[logTime]]
                </td>
                <!--end::Timestamp=-->
            </tr>
            <!--end::Table row-->
            <!--begin::Table row-->
            <tr class="assignment-log-item">
                <!--begin::Badge=-->
                <td class="min-w-70px">
                    <div class="badge badge-light-info">YÖNLENDİRME</div>
                </td>
                <!--end::Badge=-->
                <!--begin::Status=-->
                <td>
                    <small>[[logNote]]</small>
                </td>
                <!--end::Status=-->
                <!--begin::Timestamp=-->
                <td class="pe-0 text-end min-w-200px text-muted fs-7">
                        <i class="far fa-calendar"></i> [[logDate]] <i class="far fa-clock"></i> [[logTime]]
                </td>
                <!--end::Timestamp=-->
            </tr>
            <!--end::Table row-->
            <!--begin::Table row-->
            <tr class="end-log-item">
                <!--begin::Badge=-->
                <td class="min-w-70px">
                    <div class="badge badge-light-dark">END</div>
                </td>
                <!--end::Badge=-->
                <!--begin::Status=-->
                <td>
                    <small>[[logNote]]</small>
                </td>
                <!--end::Status=-->
                <!--begin::Timestamp=-->
                <td class="pe-0 text-end min-w-200px text-muted fs-7">
                        <i class="far fa-calendar"></i> [[logDate]] <i class="far fa-clock"></i> [[logTime]]
                </td>
                <!--end::Timestamp=-->
            </tr>
            <!--end::Table row-->
        </tbody>
    </table>
</div>