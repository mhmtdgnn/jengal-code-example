@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-15" placeholder="Taleplerde Ara" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Filtrele
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-350px w-md-350px" data-kt-menu="true"
                            id="kt-toolbar-filter">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-4 text-dark fw-bolder">Filtre Seçenekleri</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5">
                                <form action="" method="GET">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Müşteri Telefon Numarası:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid fw-bolder" name="filter_consumer_phone" id="filter_consumer_phone" placeholder="(___) ___-____">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <div class="col-12">
                                            <!--begin::Label-->
                                            <label class="form-label fs-7 fw-bold mb-3">Müşteri Adı Soyadı</label>
                                            <!--end::Label-->
                                            <div class="row fv-row fv-plugins-icon-container">
                                                <div class="col-6">
                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-sm form-control-solid fw-bolder" name="filter_consumer_firstname" placeholder="Müşteri Adı">
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-6">
                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-sm form-control-solid fw-bolder" name="filter_consumer_lastname" placeholder="Müşteri Soyadı">
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Talep Kodu:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid fw-bolder" name="filter_request_code" placeholder="Talep Kodu">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Talep Tipi:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="filter_request_type" class="form-select form-select-sm form-select-solid fw-bolder" data-kt-select2="true"
                                            data-placeholder="Seçiniz" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($types as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Durum:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="filter_status" class="form-select form-select-sm form-select-solid fw-bolder" data-kt-select2="true"
                                            data-placeholder="Seçiniz" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($statuses as $item)
                                                <option value="{{ $item->status_code }}">{{ $item->status_name }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('bicozumExpress.companyPickupRequests') }}" class="btn btn-info btn-sm me-2">Tümünü Gör</a>
                                        <button type="reset" class="btn btn-light btn-active-light-primary btn-sm me-2"
                                        data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Temizle</button>
                                        <button type="submit" class="btn btn-primary btn-sm" data-kt-menu-dismiss="true"
                                            data-kt-customer-table-filter="filter">Uygula</button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Add customer-->
                        <a href="{{ route('bicozumExpress.createPickupRequest') }}" class="btn btn-primary">Yeni Evden Alım Talebi</a>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-100px">Talep No</th>
                            <th class="w-150px">Talep Tipi</th>
                            <th class="min-w-125px">Durum</th>
                            <th class="min-w-125px">Detaylar</th>
                            <th class="text-end min-w-70px">İşlem</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($pickups as $item)
                        <tr>
                            <td>
                                <a href="#"
                                    class="text-gray-800 text-hover-primary mb-1">{{ $item->id }}</a>
                            </td>
                            <td>
                                <small class="text-info">{{ $item->name }}</small>
                            </td>
                            <td>
                                <div class="badge badge-{{ $item->status_color }}">{{ $item->status_name }}</div>
                            </td>
                            <td>
                                Müşteri : {{ $item->firstName.' '.$item->lastName }} - {{ $item->phone }}<br>
                                <small class="text-muted">Talep Tarihi : {{ $item->created_at }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('bicozumExpress.pickupRequestDetail', $item->id) }}" class="btn btn-sm btn-light btn-active-light-primary">İncele</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
                {{ $pickups->links() }}
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

        <!--begin::Modals-->

        <!--end::Modals-->
    </div>
    <!--end::Container-->
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
@endsection