<!--begin::Modal - Başlangıç Adresi Modal-->
<div class="modal fade" id="add_start_address_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-700px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 d-flex justify-content-end">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
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
            <div class="modal-body scroll-y mx-5 mx-xl-10 pt-0 pb-15">
                <!--begin::Heading-->
                <div class="text-center position-relative mb-13">
                    <div class="position-absolute top-50 start-0 translate-middle">
                        <span class="badge rounded-circle bg-secondary text-info transport-id"></span>
                    </div>
                    <!--begin::Title-->
                    <h1 class="d-flex justify-content-center align-items-center mb-3">Başlangıç Adresi Seçin</h1>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->
                <!--begin::Description-->
                <form id="add_start_address_form" class="form-group row">
                    @csrf
                    <input type="hidden" name="transport_id" value="0">
                    <div class="col-md-12 mb-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-map-pin fs-1"></i>
                            </span>
                            <select name="service_point" class="form-control">
                                <option value="">Servis noktası seçiniz</option>
                            </select>
                        </div>
                        <small class="text-muted">
                            Servin noktası seçerek adresi otomatik doldurabilirsiniz.
                        </small>
                    </div>
                    <div class="col-md-6">
                        <select name="city" class="form-select" id="add_start_address_cities">
                            <option value="">İl seçiniz</option>
                            @foreach ($cities as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="town" class="form-select" id="add_start_address_towns">
                            <option value="">Önce il seçiniz</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-4">
                        <textarea name="address" rows="5" class="form-control" placeholder="Açık adres..."></textarea>
                    </div>
                    <div class="col-md-12 mt-4 text-center">
                        <button type="button" id="add_start_address_form_button" class="btn btn-info px-12 mt-8">
                            <span class="indicator-label">
                                Güncelle
                            </span>
                            <span class="indicator-progress">
                                Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
                <!--end::Description-->
            </div>
            <!--end::Modal Body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Başlangıç Adresi Modal-->