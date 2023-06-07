<!--begin::Modal - Sefer Planla Modal-->
<div class="modal fade" id="trip_plan_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 d-flex justify-content-end">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-10 pt-3 pb-15">
                <!--begin::Heading-->
                <div class="text-center mb-8">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-start align-items-center position-relative mb-3 h1">
                        <i class="fas fa-truck fs-3x me-4"></i> Sefer Planla
                        <div class="position-absolute top-0 start-0 translate-middle">
                            <span class="badge rounded-circle bg-secondary text-info transport-id"></span>
                        </div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->
                <!--begin::Transport Detail-->
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Genel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Logs</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="border rounded h-100 p-4">
                                    <span class="d-inline-block position-relative mb-2">
                                        <span class="d-inline-block mb-2 fs-7tx fw-bold">
                                            Talep Bilgileri
                                        </span>
                                        <span
                                            class="d-inline-block position-absolute h-4px bottom-0 end-0 start-0 bg-success translate rounded"></span>
                                    </span>
                                    <div class="request-content mt-8">
                                        <strong class="w-100px d-inline-block me-3">Talep No </strong> : <strong
                                            id="transport_code"></strong> <br>
                                        <strong class="w-100px d-inline-block me-3">Referans No </strong> : <strong
                                            id="reference_number"></strong> <br>
                                        <strong class="w-100px d-inline-block me-3">Talep Tipi </strong> : <span
                                            id="type"></span> <br>
                                        <strong class="w-100px d-inline-block me-3">Kapıda Ödeme </strong> : <span
                                            id="payment_at_door"></span> <br>
                                        <strong class="w-100px d-inline-block me-3">Açıklama </strong> : <span
                                            id="delivery_type"></span> <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="border rounded h-100 p-4">
                                    <span class="d-inline-block position-relative mb-2">
                                        <span class="d-inline-block mb-2 fs-7tx fw-bold">
                                            Hedef bilgileri
                                        </span>
                                        <span
                                            class="d-inline-block position-absolute h-4px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    </span>
                                    <div class="delivery-address-content mt-8">
                                        <span class="contact-name"></span> <br>
                                        <span class="contact-number"></span> <br>
                                        <address class="mt-3"></address>
                                        <strong class="city-town"></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        <div id="log_items" class="row min-h-200px">
                            <div class="table-responsive">
                                <table class="table table-hover table-rounded table-striped border gy-4 gs-4">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="trip_plan_form" class="row pt-8 mt-8">
                    @csrf
                    <input type="hidden" name="transport_id" value="0">
                    <input type="hidden" name="transport_type_id" value="0">
                    <input type="hidden" name="transport_reference_number" value="0">
                    <div class="col-lg-6">
                        <select id="select_planned_date" class="form-select form-select-transparent" name="planned_date"
                            data-placeholder="..." required>
                            <option value=""></option>
                            @foreach (json_decode($datePeriod, true) as $key => $value)
                                <option value="{{ $key }}">
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select id="select_vehicle" class="form-select form-select-transparent" name="vehicle"
                            data-placeholder="..." required>
                            <option value=""></option>
                            @foreach ($vehicles as $item)
                                <option value="{{ $item->id }}"
                                    data-kt-rich-content-subcontent="{{ $item->name }}"
                                    data-kt-rich-content-driver="{{ $item->driver->name . ' ' . $item->driver->surname }}"
                                    data-kt-rich-content-icon="{{ asset('assets/media/logos/biportal-logo-blue.png') }}">
                                    {{ $item->plate_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row my-8">
                        <div class="col-lg-9">
                            <div class="input-group">
                                <span class="input-group-text bg-light-info text-info">NOTE</small></span>
                                <textarea name="operation_note" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-3 text-end">
                            <button type="button" id="trip_plan_form_button" class="btn btn-info px-12 mt-8">
                                <span class="indicator-label">
                                    Planla
                                </span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
                <!--end::Transport Detail-->
                </span>
                <!--end::Modal Body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Sefer Planla Modal-->
