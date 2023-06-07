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
                        {{-- <!--begin::Filter-->
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
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                            id="kt-toolbar-filter">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-4 text-dark fw-bolder">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold mb-3">Month:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true"
                                        data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
                                        <option></option>
                                        <option value="aug">August</option>
                                        <option value="sep">September</option>
                                        <option value="oct">October</option>
                                        <option value="nov">November</option>
                                        <option value="dec">December</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold mb-3">Payment Type:</label>
                                    <!--end::Label-->
                                    <!--begin::Options-->
                                    <div class="d-flex flex-column flex-wrap fw-bold"
                                        data-kt-customer-table-filter="payment_type">
                                        <!--begin::Option-->
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                            <input class="form-check-input" type="radio" name="payment_type"
                                                value="all" checked="checked" />
                                            <span class="form-check-label text-gray-600">All</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                            <input class="form-check-input" type="radio" name="payment_type"
                                                value="visa" />
                                            <span class="form-check-label text-gray-600">Visa</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" name="payment_type"
                                                value="mastercard" />
                                            <span class="form-check-label text-gray-600">Mastercard</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" name="payment_type"
                                                value="american_express" />
                                            <span class="form-check-label text-gray-600">American Express</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                        data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                    <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                        data-kt-customer-table-filter="filter">Apply</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div> --}}
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
                        <!--begin::Add customer-->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#transport_request_modal">Yeni Taşıma Talebi</button>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none"
                        data-kt-customer-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-info" id="plan_button" data-bs-toggle="modal" data-bs-target="#plan_modal">Planla</button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-4" id="kt_customers_table">
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
                            <th class="w-150px">Taşıma Kodu</th>
                            <th class="w-auto">İrtibat Bilgisi</th>
                            <th class="w-200px">Hedef Adres</th>
                            <th class="w-150px text-center">Randevu Tarihi</th>
                            <th class="w-150px">Talep Tarihi</th>
                            <th class="w-50px text-end"></th>
                            <th class="w-175px text-end">İşlem</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($transport_requests as $item)
                        <tr class="transport-request-{{ $item->id }} {{ ($item->status_id == 2030) ? 'bg-light-warning' : '' }}">
                            <!--begin::Checkbox-->
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input choosen" type="checkbox" value="{{ $item->id }}" />
                                </div>
                            </td>
                            <!--end::Checkbox-->
                            <td>
                                <a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $item->transport_code }}</a>
                            </td>
                            <td>
                                <small class="d-block text-dark">{{ $item->contact_name }}</small>
                                <small class="d-block text-muted">{{ $item->contact_number }}</small>
                            </td>
                            {{-- <td class="start-address">
                                @if (!is_null($item->from_city) || !is_null($item->from_town))
                                    <small class="text-gray-600 text-hover-primary mb-1">{{ $item->from_city . '/' . $item->from_town }}</small>
                                @else
                                    <span role="button" class="btn btn-sm btn-light add-start-address" data-id="{{ $item->id }}">
                                        <i class="las la-map-marker"></i> Adres Ekle
                                    </span>
                                @endif
                            </td> --}}
                            <td class="delivery-address">
                                @if (!is_null($item->to_city) || !is_null($item->to_town))
                                    <span role="button" class="add-delivery-address" data-id="{{ $item->id }}">
                                        <small class="text-gray-600 text-hover-primary mb-1">{{ $item->to_city . '/' . $item->to_town }}</small>
                                    </span>
                                @else
                                    <span role="button" class="btn btn-sm btn-light add-delivery-address" data-id="{{ $item->id }}">
                                        <i class="las la-map-marker"></i> Adres Ekle
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (!is_null($item->appointment_date))
                                    <strong class="text-info">{{ $item->appointment_date }}</strong>
                                @else
                                    <span role="button" class="btn btn-sm btn-light add-planned-date" data-id="{{ $item->id }}">
                                        <i class="las la-calendar-alt"></i> Tarih Ekle
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small>
                                    <strong class="me-3">{{ date_format($item->created_at, 'Y-m-d') }} </strong>
                                    <span class="text-muted">{{ date_format($item->created_at, 'H:i') }}</span>
                                </small>
                            </td>
                            <td>
                                @switch($item->delivery_type)
                                    @case(0)
                                        <i class="fas fa-angle-double-left fs-1 text-primary"></i>
                                        @break
                                    @case(1)
                                        <i class="fas fa-angle-double-right fs-1 text-success"></i>
                                        @break
                                @endswitch
                            </td>
                            <td class="text-end">
                                <span
                                    data-id="{{ $item->id }}"
                                    class="btn btn-sm btn-light border border-primary btn-active-light-primary text-primary trip-plan-button">
                                    <span class="indicator-label">
                                        <i class="las la-truck text-primary"></i> Planla
                                    </span>
                                    <span class="indicator-progress">
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </span>
                                <span data-id="{{ $item->id }}" 
                                    class="btn btn-sm btn-icon btn-light-danger trip-cancel-button">
                                    <i class="las la-ban fs-1"></i>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
                {{ $transport_requests->links() }}
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

        <!--begin::Modals-->
        <!--begin::Modal - Create Transport Request-->
		<div class="modal fade" id="transport_request_modal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header border-0">
						<!--begin::Title-->
                        <div class="d-flex justify-content-start align-items-center position-relative ms-10 mt-5 mb-3 h1">
                            <i class="fas fa-truck fs-3x me-4"></i> Sefer Planla
                            <div class="position-absolute top-0 start-0 translate-middle">
                                <span class="badge rounded-circle bg-secondary text-info transport-id">YENİ</span>
                            </div>
                        </div>
                        <!--end::Title-->
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Close-->
					</div>
					<!--end::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body py-lg-10 px-lg-10">
                        <form action="" id="transport_request_modal_form">
                            @csrf
                            <div class="border border-hover-primary p-7 rounded mb-7">
                                <span class="d-inline-block position-relative mb-8">
                                    <span class="d-inline-block mb-2 fs-4 fw-bold">
                                        Taşıma Bilgileri
                                    </span>
                                    <span class="d-inline-block position-absolute h-6px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <div class="row">
                                    <div class="col-lg-5 fv-row fv-plugins-icon-container">
                                        <div class="mb-2">
                                            <select name="transport_type" class="form-select form-select-lg form-select-solid mb-3 mb-lg-0" required>
                                                <option value="1" selected>GENEL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 fv-row fv-plugins-icon-container">
                                        <div class="mb-2">
                                            <input type="text" 
                                                name="reference_number" 
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="Referans No">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 fv-row fv-plugins-icon-container">
                                        <div class="mb-2">
                                            <div class="form-check form-check-custom form-check-primary form-check-solid mb-1">
                                                <input name="delivery_type" class="form-check-input" type="radio" value="0" id="flexCheckboxLg" checked/>
                                                <label class="form-check-label" for="flexCheckboxLg">
                                                    TESLİM AL
                                                </label>
                                            </div>
                                            
                                            <div class="form-check form-check-custom form-check-success form-check-solid">
                                                <input name="delivery_type" class="form-check-input" type="radio" value="1" id="flexCheckboxSm"  />
                                                <label class="form-check-label" for="flexCheckboxSm">
                                                    TESLİM ET
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <!--begin::Input group-->
                                        <div class="input-group input-group-solid">
                                            <span class="input-group-text bg-light-info text-info">NOTE <small>(opsiyonel)</small></span>
                                            <textarea name="operation_note" class="form-control" aria-label="With textarea"></textarea>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                            </div>
                            <div class="border border-hover-primary p-7 rounded mb-7" id="product_item_repeater">
                                <span class="d-inline-block position-relative mb-8">
                                    <span class="d-inline-block mb-2 fs-4 fw-bold">
                                        Taşınacak Ürün
                                    </span>
                                    <span class="d-inline-block position-absolute h-6px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <div data-repeater-list="products">
                                    <div class="row mb-4 position-relative" data-repeater-item>
                                        <div class="col-lg-2 fv-row fv-plugins-icon-container">
                                            <input type="number"
                                                name="piece"
                                                min="1"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="ADET"
                                                required>
                                        </div>
                                        <div class="col-lg-9 fv-row fv-plugins-icon-container">
                                            <select type="text"
                                                name="product_id"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 product-data-ajax"
                                                placeholder="Ürün Açıklaması"
                                                required></select>
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="button" class="btn btn-icon btn-light" data-repeater-delete>
                                                <i class="fas fa-backspace text-danger"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-5">
                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                        <i class="la la-plus"></i>Add
                                    </a>
                                </div>
                            </div>
                            <div class="border border-hover-primary p-7 rounded mb-7">
                                <span class="d-inline-block position-relative mb-8">
                                    <span class="d-inline-block mb-2 fs-4 fw-bold">
                                        Hedef Adres Bilgileri
                                    </span>
                                    <span class="d-inline-block position-absolute h-6px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <div class="row">
                                    <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                        <div class="mb-2">
                                            <select name="destination_city"
                                                id="add_destination_address_cities"
                                                class="form-select form-select-solid"
                                                required>
                                                <option value="">İl Seçin...</option>
                                                @foreach ($cities as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <select name="destination_town"
                                                id="add_destination_address_towns"
                                                class="form-select form-select-solid"
                                                required>
                                                <option value="">Önce İl Seçin...</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" 
                                                name="contact_name" 
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="İrtibat İsim" required>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" 
                                                name="contact_number" 
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="İrtibat Telefon" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                        <textarea name="destination_address" class="form-control form-control-solid h-200px" placeholder="Açık adress" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="text-end">
                            <button id="transport_request_modal_button"
                                class="btn btn-lg btn-primary px-12">
                                <span class="indicator-label">
                                    GÖNDER
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
					</div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - Create Transport Request-->
        <!--end::Modals-->
    </div>
    <!--end::Container-->
@endsection

@section('extra_content')
    @include('transport.partials.modals.add-start-address')
    @include('transport.partials.modals.add-delivery-address')
    @include('transport.partials.modals.trip-plan')
@endsection

@include('transport.partials.footer-scripts')