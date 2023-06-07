<div class="modal-content shadow-none">
    <div class="modal-header">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-center w-100 py-0">
            <!--begin::store-->
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center">
                    <span class="badge badge-info p-3 me-2">{{ $order->id }}</span>
                    <span class="text-gray-700 fs-2 fw-bold me-1">Sipariş Bilgileri</span>
                </div>
            </div>
            <!--end::store-->
        </div>
        <!--end::Title-->

        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-light-primary text-muted ms-2" data-bs-dismiss="modal"
            aria-label="Close">
            <i class="las la-times fs-1"></i>
        </div>
        <!--end::Close-->
    </div>

    <div class="modal-body">
        <div class="pt-9 pb-0">
            <div class="row mb-12">
                <div class="col-lg-3">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5">
                                Müşteri Bilgileri
                            </span>
                            <span
                                class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <div class="d-block align-items-center">
                            <span class="d-block">{{ $order->consumer->firstName ?? '' }}
                                {{ $order->consumer->lastName ?? '' }}</span>
                            <span class="d-block">{{ $order->consumer->phone ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <div class="row">
                            <div class="col-lg-4">
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-4">
                                    <span class="d-inline-block mb-1 fs-5">
                                        Tarih / Saat
                                    </span>
                                    <span
                                        class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <!--end::Underline-->
                                <div class="d-block align-items-center">
                                    {{ $order->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-4">
                                    <span class="d-inline-block mb-1 fs-5">
                                        Sipariş No / Tarihi
                                    </span>
                                    <span
                                        class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <!--end::Underline-->
                                <div class="d-block align-items-center">
                                    <span class="d-block">{{ $order->siparis_kodu }}</span>
                                    <span class="d-block">{{ $order->siparis_tarihi }}</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-4">
                                    <span class="d-inline-block mb-1 fs-5">
                                        Teslimat Bilgileri
                                    </span>
                                    <span
                                        class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <!--end::Underline-->
                                <div class="d-block align-items-center">
                                    <span class="d-block">{{ $order->teslimat_adresi1 }}</span>

                                    @if($order->teslimat_adresi2)
                                    <span class="d-block">{{ $order->teslimat_adresi2 }}</span>
                                    @endif

                                    <span class="d-block">
                                        @if(!empty($order->teslimat_il_ups))
                                            <small>{{ $order->ups_il->city_name }}</small>
                                        @else
                                            <small class="text-danger">-</small>
                                        @endif
                                        /
                                        @if(!empty($order->teslimat_ilce_ups))
                                            <small>{{ $order->ups_ilce->area_name }}</small>
                                        @else
                                            <small class="text-danger">-</small>
                                        @endif
                                    </span>
                                    <span class="d-block">{{ $order->teslimat_posta_kodu }}</span>

                                    @if($order->teslimat_tarif)
                                    <h3>Tarif:</h3>
                                    <span class="d-block">{{ $order->teslimat_tarif }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold ps-4">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active"
                        data-bs-toggle="tab"
                        href="#kt_tab_pane_1">
                        Sipariş Detayı
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0"
                        data-bs-toggle="tab"
                        href="#kt_tab_pane_2">
                        Log
                    </a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="kt_tab_pane_1" role="tabpanel">
                    <div class="border rounded p-5">
                        <table class="table caption-top">
                            <caption>Ürün Bilgisi</caption>
                            <thead>
                                <tr class="bg-light">
                                    <th scope="col" class="ps-2">
                                        <span class="text-info">#</span>
                                    </th>
                                    <th scope="col">Stok Kodu</th>
                                    <th scope="col">Ürün Adı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->detail as $item)
                                    <tr class="border-bottom">
                                        <th scope="row">
                                            <span class="text-info">{{ $item->id }}</span>
                                        </th>
                                        <td>{{ $item->product_code }}</td>
                                        <td>{{ $item->product_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    @if(count($order->logs) > 0)
                        <div class="table p-8 border rounded">
                            <table class="table table-row-dashed gy-2 gs-2">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                        <th>Tarih</th>
                                        <th>Kullanıcı</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($log->sortByDesc('id') as $lg)
                                    <tr>
                                        <td>
                                            <small>{{ $lg->created_at->format('d-m-Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ $lg->kullanici->name }}</span>
                                        </td>
                                        <td>
                                            <small>{{ $lg->type_key }} - {{ $lg->description }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="border rounded p-5">
                            <span class="fs-5 text-info fw-bold me-1">Bu siparişe bağlı herhangi bir işlem gerçekleştirilmemiştir.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
        @if($order->durum == 1)
        <button type="button" id="rejectTheOrder" data-id="{{ $order->id }}" class="btn btn-danger">
            <span class="indicator-label">
                Siparişi İptal Et
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
        @endif
    </div>
</div>
