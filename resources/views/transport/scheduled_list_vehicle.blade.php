@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <div class="row mb-8">
            <div class="col-lg-6">
                <div class="card h-150px">
                    <div class="position-absolute top-50 end-0 translate-middle-y opacity-10 pe-none text-end">
                        <img src="{{ asset('assets/media/icons/duotune/ecommerce/ecm006.svg') }}" class="w-125px">
                    </div>
                    <div class="card-body">
                        <strong class="d-block text-info fs-2x">{{ $vehicle->plate_number }}</strong>
                        <span class="d-block fs-4">{{ $vehicle->name }}</span>
                        <strong class="d-block fs-3">{{ mb_strtoupper($driver->name) . ' ' . mb_strtoupper($driver->surname) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-150px">
                    <div class="position-absolute top-50 end-0 translate-middle-y opacity-10 pe-none text-end">
                        <img src="{{ asset('assets/media/icons/duotune/maps/map008.svg') }}" class="w-125px">
                    </div>
                    <div class="card-body d-flex align-items-center">
                        <span class="fw-bold text-gray-700" style="font-size: 3rem">
                            {{ count($plannedDeliveries) }} Teslimat Noktası
                        </span>
                    </div>
                </div>
            </div>
        </div>
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
                        <!--begin::Export-->
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
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
                        </button>
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
                            <th class="min-w-125px">Plan Tarihi</th>
                            <th class="min-w-125px">Taşıma</th>
                            <th class="min-w-125px">Status</th>
                            {{-- <th class="min-w-125px">Başlangıç Adresi</th> --}}
                            <th class="min-w-125px">Teslimat Adresi</th>
                            <th class="min-w-125px">Talep Tarihi</th>
                            <th class="text-end min-w-70px">İşlem</th>
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
                                <a href="#"
                                    class="text-gray-800 text-hover-primary mb-1">{{ $item->transport_code }}</a>
                            </td>
                            <td>
                                <small class="text-gray-800 text-hover-primary mb-1">{{ $item->planned_date }}</small>
                            </td>
                            <td>
                                <span class="badge badge-secondary">
                                    <small>{{ $item->type }}</small>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $item->status_color }}">
                                    <small>{{ $item->status }}</small>
                                </span>
                            </td>
                            {{-- <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                    <small>{{ $item->from_city . '/' . $item->from_town }}</small>
                                </a>
                            </td> --}}
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                    <small>{{ $item->to_city . '/' . $item->to_town }}</small>
                                </a>
                            </td>
                            <td>
                                <small>
                                    <strong class="me-3">{{ date_format($item->created_at, 'Y-m-d') }} </strong>
                                    <span class="text-muted">{{ date_format($item->created_at, 'H:i') }}</span>
                                </small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('bicozumExpress.transportDetail', ['transport_code' => $item->transport_code]) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                    İncele
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
    </div>
    <!--end::Container-->
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/customers/list/list.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom/apps/customers/add.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/widgets.js') }}"></script> --}}
    <script src="{{ asset('assets/js/custom/modals/create-transport-request.js') }}"></script>
    <!--end::Page Custom Javascript-->
@endsection