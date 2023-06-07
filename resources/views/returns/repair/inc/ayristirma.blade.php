<form
    action="{{ route('returns.repair.save') }}"
    method="POST"
    class="form fv-plugins-bootstrap5 fv-plugins-framework"
    id="ayristirmaFormu"
    novalidate="novalidate"
    enctype="multipart/form-data">
    <div class="mb-3">
        @csrf
        <input type="hidden" id="return_detail_id" name="return_detail_id">
        <input type="hidden" name="return_id">
        <input type="hidden" name="product_iris_kategori" id="product_iris_kategori">
        <div class="w-100">
            <div class="fv-row mb-3 fv-plugins-icon-container">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-center w-100 pb-5">
                    <!--begin::store-->
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-info p-3 me-2 return_id"></span>
                            <span class="text-gray-700 fs-2 fw-bold me-1">Talep Bilgileri</span>
                        </div>
                    </div>
                    <!--end::store-->
                </div>
                <!--end::Title-->
                <div class="separator separator-dashed border-primary mb-10"></div>
                <div class="row my-8">
                    <div class="col-md-4">
                        <div class="d-flex flex-column h-100 bg-light-info p-4 border border-info rounded">
                            <div class="mb-4">
                                <span class="d-inline-block position-relative">
                                    <span class="d-inline-block mb-2 fs-2 fw-bold">
                                        Ürün Bilgileri
                                    </span>
                                    <span class="d-inline-block position-absolute h-4px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                            </div>
                            <span class="mb-3" id="product_name"></span>
                            <strong class="mb-3" id="product_code"></strong>
                        </div>
                    </div>
                    <div class="col-md-8 p-4 border rounded">
                        <div class="mb-4">
                            <span class="d-inline-block position-relative">
                                <span class="d-inline-block mb-2 fs-2 fw-bold d-none returnText">
                                    İade Durumu
                                </span>
                                <span class="d-inline-block mb-2 fs-2 fw-bold d-none changeText">
                                    Değişim Durumu
                                </span>
                                <span class="d-inline-block position-absolute h-4px bottom-0 end-0 start-0 bg-success translate rounded"></span>
                            </span>
                        </div>
                        {{-- <br>
                        <select class="form-select form-select-solid" id="iade_durumu" name="iade_durumu" required onChange="changeBox2(this.selectedIndex);" class="required">
                            <option value="">Seçiniz</option>
                            <option value="1">Kabul</option>
                            <option value="2">Red</option>
                        </select> --}}
                        <!--begin::Radio group-->
                        <div class="row d-none returnSelection" data-kt-buttons="true">
                            <!--begin::Radio button-->
                            <div class="col-lg-4">
                                <label
                                    class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="plan" value="1" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap">
                                                KABUL
                                                <i class="fas fa-box-open ms-3 fs-2 text-success p-0"></i>
                                            </h2>
                                            <div class="fw-semibold opacity-50">
                                                SATIŞA UYGUN
                                            </div>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <div class="col-lg-4">
                                <label
                                    class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="plan" value="2" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap">
                                                KABUL
                                                <i class="fas fa-tools ms-3 fs-2 text-info p-0"></i>
                                            </h2>
                                            <div class="fw-semibold opacity-50">
                                                TAMİR GEREKLİ
                                            </div>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <div class="col-lg-4">
                                <label
                                    class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="plan" value="3" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap">
                                                RET
                                                <i class="fas fa-exclamation ms-3 fs-2 text-danger p-0"></i>
                                            </h2>
                                            <div class="fw-semibold opacity-50">
                                                GERİ GÖNDER
                                            </div>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <!--end::Radio button-->
                            <div class="col-md-12" style="display: none" id="ayristirma">
                                <label class="fw-bolder" for="ayristirma_id">Ayrıştırma Durumu</label>
                                <select class="form-select form-select-solid mb-3" id="ayristirma_id"
                                    name="ayristirma_id">
                                    <option value="">Seçiniz</option>
                                    <option value="1">Y1 - Sıfır Ürün</option>
                                    <option value="2">Y2 - YeniGibi(A)</option>
                                    <option value="3">Y3 - Çok İyi(B)</option>
                                    <option value="4">Y4 - İyi(C)</option>
                                    <option value="5">Y5 - Hurda(H)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none changeSelection" data-kt-buttons="true">
                            <!--begin::Radio button-->
                            <div class="col-lg-6">
                                <label
                                    class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="changeplan" value="1" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap">
                                                KABUL
                                                <i class="fas fa-box-open ms-3 fs-2 text-success p-0"></i>
                                            </h2>
                                            <div class="fw-semibold opacity-50">
                                                DEĞİŞİME UYGUN
                                            </div>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <div class="col-lg-6">
                                <label
                                    class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="changeplan" value="2" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap">
                                                TAMİR
                                                <i class="fas fa-exclamation ms-3 fs-2 text-danger p-0"></i>
                                            </h2>
                                            <div class="fw-semibold opacity-50">
                                                TAMİR GEREKLİ
                                            </div>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <!--end::Radio button-->
                        </div>
                    </div>
                </div>
                <div class="separator separator-dashed border-primary my-10"></div>
                <div class="row my-8">
                    <div class="col-md-6">
                        <textarea class="form-control form-control-solid" id="servis_notu" placeholder="Servis Notu" rows="5"
                            name="servis_notu"></textarea>
                    </div>
                    <div class="col-md-6">
                        <textarea class="form-control form-control-solid" id="servis_dahili_notu" placeholder="Servis Dahili Notu"
                            rows="5" name="servis_dahili_notu"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <a class="btn btn-lg btn-light-info product_barcode d-none"
        type="button"
        data-ayristirma-id="">
        <i class="bi bi-upc pe-0 fs-3"></i>
        Barkod
    </a>
    <button type="submit" class="btn btn-lg btn-primary float-end ayritirmaSubmitButton">
        <span class="indicator-label">
            Kaydet
        </span>
        <span class="indicator-progress">
            Lütfen Bekleyiniz...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
</form>
