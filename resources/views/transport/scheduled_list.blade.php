@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 py-6">
                <!--begin::Card title-->
                {{-- <div class="card-title">
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
                </div> --}}
                <div class="d-flex justify-content-center align-items-center">
                    <a href="/bicozum-express/scheduled-transportations/3" class="badge bg-light-info border border-info d-block me-2">
                        <small class="text-dark">34 CVZ 424</small>
                        <small class="text-info">PEUGEOT BOXER</small>
                        <small class="d-block mt-2 text-primary">AHMET DEMİRBAŞ</small>
                    </a>
                    <a href="/bicozum-express/scheduled-transportations/5" class="badge bg-light-info border border-info d-block me-2">
                        <small class="text-dark">34 DBJ 901</small>
                        <small class="text-info">PEUGEOT BOXER</small>
                        <small class="d-block mt-2 text-primary">ÖZKAN EKİCİ</small>
                    </a>
                    <a href="/bicozum-express/scheduled-transportations/4" class="badge bg-light-info border border-info d-block me-2">
                        <small class="text-dark">34 GBH 413</small>
                        <small class="text-info">CİTROEN C3</small>
                        <small class="d-block mt-2 text-primary">SERTAN KAHRAMAN</small>
                    </a>
                    <a href="/bicozum-express/scheduled-transportations/1" class="badge bg-light-info border border-info d-block me-2">
                        <small class="text-dark">34 EYF 155</small>
                        <small class="text-info">PEUGEOT PARTNER</small>
                        <small class="d-block mt-2 text-primary">ARİF YILMAZ</small>
                    </a>
                    <a href="/bicozum-express/scheduled-transportations/2" class="badge bg-light-info border border-info d-block me-2">
                        <small class="text-dark">41 AJD 217</small>
                        <small class="text-info">PEUGEOT PARTNER</small>
                        <small class="d-block mt-2 text-primary">BEKİM OKAN KALKAN</small>
                    </a>
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
                        <form class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
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
                                <!--begin::Input group-->
                                <div class="mb-6">
                                    <!--begin::Input-->
                                    <input type="text" 
                                        name="fcode" 
                                        class="form-control form-control-solid" 
                                        placeholder="TALEP NO" 
                                        value="{{ request('fcode') }}"
                                        autocomplete="off"/>
                                    <!--end::Input-->
                                </div>
                                <div class="mb-6">
                                    <!--begin::Input-->
                                    <select name="fstatus" class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                        data-placeholder="STATUS" data-allow-clear="true"
                                        data-kt-customer-table-filter="status" data-dropdown-parent="#kt-toolbar-filter">
                                        <option value=""></option>
                                        @foreach ($statuses as $item)
                                            <option 
                                                value="{{ $item->status_code }}" 
                                                {{ ($item->status_code == request("fstatus")) ? 'selected' : '' }}>
                                                {{ $item->status_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <div class="mb-6">
                                    <!--begin::Input-->
                                    <input type="text" 
                                        name="fname" 
                                        class="form-control form-control-solid" 
                                        placeholder="TESLİM İRTİBAT"
                                        value="{{request("fname")}}"
                                        autocomplete="off"/>
                                    <!--end::Input-->
                                </div>
                                <div class="mb-6">
                                    <div class="position-relative d-flex align-items-center">
                                        <span class="position-absolute mx-6">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        <input type="text" 
                                            name="fplandate" 
                                            id="filter_planned_date"
                                            class="form-control form-control-solid ps-12 flatpickr-input active" 
                                            placeholder="PLANLANAN TARİH" 
                                            value="{{ request('fplandate') }}"
                                            readonly="readonly">
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <a href="{{ url()->current() }}" class="btn btn-light btn-active-light-primary me-2"
                                        data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Temizle</a>
                                    <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                        data-kt-customer-table-filter="filter">Uygula</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </form>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Export-->
                        {{-- <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                            data-bs-target="#kt_customers_export_modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2"
                                        rx="1" transform="rotate(90 12.75 4.25)" fill="black" />
                                    <path
                                        d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                        fill="black" />
                                    <path
                                        d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                        fill="#C4C4C4" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Dışa Aktar
                        </button> --}}
                        <!--end::Export-->
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
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-125px">Talep No</th>
                            <th class="min-w-125px">Status</th>
                            <th class="min-w-125px">Taşıma Tipi</th>
                            <th class="min-w-125px">Teslim İrtibat</th>
                            <th class="min-w-125px">Teslimat Adresi</th>
                            <th class="min-w-125px">Araç</th>
                            <th class="min-w-125px">Planlanan Tarih</th>
                            <th class="text-end min-w-100px">İşlem</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($plannedDeliveries as $item)
                        <tr>
                            <!--begin::Checkbox-->
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input choosen" type="checkbox" value="{{ $item->id }}" />
                                </div>
                            </td>
                            <!--end::Checkbox-->
                            <td>
                                <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                    {{ $item->transport_code }}
                                </a>
                            </td>
                            <td>
                                <span class="badge badge-{{ $item->status_color }}">
                                    <small>{{ $item->status }}</small>
                                </span>
                            </td>
                            <td>
                                <strong class="text-gray-400">
                                    <small>{{ $item->transport_type }}</small>
                                </strong>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                    <small>{{ $item->to_name }}</small>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                    <small>{{ $item->to_city . '/' . $item->to_town }}</small>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('bicozumExpress.scheduledTransportationVehicle', ['vehicle_id' => $item->vehicle_id ]) }}" class="badge badge-secondary d-block">
                                    <small class="text-dark">{{ $item->plate_number }}</small>
                                    <small class="text-info">{{ $item->vehicle }}</small>
                                    <small class="d-block mt-2 text-primary">{{ mb_strtoupper($item->driver_name) . ' ' . mb_strtoupper($item->driver_surname) }}</small>
                                </a>
                            </td>
                            <td>
                                <small>
                                    <strong class="me-3">{{ $item->planned_date }} </strong>
                                </small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('bicozumExpress.viewTransportDetail', ['transport_code' => $item->transport_code]) }}" 
                                    class="btn btn-icon btn-sm btn-light btn-active-light-primary">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('bicozumExpress.transportDetail', ['transport_code' => $item->transport_code]) }}" 
                                    class="btn btn-icon btn-sm btn-light btn-active-light-primary">
                                    <i class="fas fa-truck"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        
        <!--begin::Modal - Adjust Balance-->
        <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder">Export Customers</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16"
                                        height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                        fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2"
                                        rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="kt_customers_export_form" class="form" action="#">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-5">Select Date Range:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Pick a date"
                                    name="date" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-5">Select Export Format:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select data-control="select2" data-placeholder="Select a format"
                                    data-hide-search="true" name="format" class="form-select form-select-solid">
                                    <option value="excell">Excel</option>
                                    <option value="pdf">PDF</option>
                                    <option value="cvs">CVS</option>
                                    <option value="zip">ZIP</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <button type="reset" id="kt_customers_export_cancel"
                                    class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_customers_export_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - New Card-->
        <!--end::Modals-->
    </div>
    <!--end::Container-->
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <!--end::Page Custom Javascript-->
    <script>
        $("#filter_planned_date").flatpickr();
    </script>
@endsection