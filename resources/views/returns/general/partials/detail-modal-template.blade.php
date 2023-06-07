<div class="modal-content shadow-none">
    <div class="modal-header">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-center w-100 py-0">
            <!--begin::store-->
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center">
                    <span class="badge badge-info p-3 me-2">{{ $data->id }}</span>
                    <span class="text-gray-700 fs-2 fw-bold me-1">Talep Bilgileri</span>
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
                <div class="col-lg-6">
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
                            <span class="d-block">{{ $data->consumer->firstName ?? '' }}
                                {{ $data->consumer->lastName ?? '' }}</span>
                            <span class="d-block">{{ $data->consumer->email ?? '' }}</span>
                            <span class="d-block">{{ $data->consumer->phone ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <div class="row">
                            <div class="col-lg-6">
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
                                    {{ $data->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                @if (isset($data->refundOrderNumber))
                                    <!--begin::Underline-->
                                    <span class="d-inline-block position-relative mb-4">
                                        <span class="d-inline-block mb-1 fs-5">
                                            Sipariş No
                                        </span>
                                        <span
                                            class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    </span>
                                    <!--end::Underline-->
                                    <div class="d-block align-items-center">
                                        {{ $data->refundOrderNumber }}
                                    </div>
                                @endif
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
                        İade Detayı
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
                                    <th scope="col">İade Sebebi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->details as $item)
                                    <tr class="border-bottom">
                                        <th scope="row">
                                            <span class="text-info">{{ $item->id }}</span>
                                        </th>
                                        <td>{{ $item->product_code }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>
                                            <span class="text-primary">{{ $item->return_reason }}</span>
                                            @if(!empty($item->not))
                                            <button type="button" class="btn btn-icon btn-info ms-5" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->not }}">
                                                <!--begin::Svg Icon -->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor"/>
                                                        <rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor"/>
                                                        <rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    @if(count($data->logs) > 0)
                        @include('components.logs')
                    @else
                        <div class="border rounded p-5">
                            <span class="fs-5 text-info fw-bold me-1">Bu iadeye bağlı herhangi bir işlem gerçekleştirilmemiştir.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($actionsDisabled)
        @if ($data->status < 8)
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
            <button type="button" id="convertToRefundRequest" data-id="{{ $data->id }}" class="btn btn-info">
                <span class="indicator-label">
                    İade Talebine Dönüştür
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
            <button type="button" id="acceptTheRequest" data-id="{{ $data->id }}" class="btn btn-primary">
                <span class="indicator-label">
                    Talebi Kabul Et
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
            <button type="button" id="rejectTheRequest" data-id="{{ $data->id }}" class="btn btn-danger">
                <span class="indicator-label">
                    Talebi İptal Et
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
        @endif
    @endif
</div>
