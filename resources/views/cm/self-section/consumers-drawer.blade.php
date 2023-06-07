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

<!--begin::Consumer Drawer-->
<div 
    id="consumer_activities_drawer"
    class="bg-white"
    data-kt-drawer="true"
    data-kt-drawer-activate="true"
    data-kt-drawer-toggle="#consumer_activities_drawer_button"
    data-kt-drawer-close="#consumer_activities_drawer_close"
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
                    <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Kullanıcının Tüm Aktiviteler</a>
                </div>
                <!--end::User-->
            </div>
            <!--end::Title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-light-primary" id="consumer_activities_drawer_close">
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
            <div class="consumers-activities-list"></div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end::Consumer Drawer-->