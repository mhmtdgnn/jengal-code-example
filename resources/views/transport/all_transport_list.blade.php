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
                        @foreach ($transports as $item)
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
                                <span class="badge badge-{{ $item->status->status_color }}">
                                    <small>{{ $item->status->status_name }}</small>
                                </span>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                    <small>{{ $item->to_name }}</small>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                    <small>{{ $item->city->name ?? '' }} / {{ $item->town->name ?? '' }}</small>
                                </a>
                            </td>
                            <td>
                                <span class="badge badge-secondary d-block">
                                    <small class="d-block text-info">{{ $item->delivery->vehicle->plate_number ?? '' }}</small>
                                    <small>{{ $item->delivery->vehicle->driver->name ?? '' }} {{ $item->delivery->vehicle->driver->surname ?? '' }}</small>
                                </span>
                            </td>
                            <td>
                                <small>
                                    <strong class="me-3">{{ $item->delivery->planned_date ?? '' }} </strong>
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
                {{ $transports->links() }}
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
    <script>
        $("#filter_planned_date").flatpickr();
    </script>
    <!--end::Page Custom Javascript-->
@endsection