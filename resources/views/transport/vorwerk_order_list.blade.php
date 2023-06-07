@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card toolbar-->
                <div class="card-toolbar d-flex justify-content-end w-100">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                        <div class="menu menu-sub menu-sub-dropdown w-350px w-md-350px" data-kt-menu="true">
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
                                        <label class="form-label fs-7 fw-bold mb-3">Sipariş Kodu:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid fw-bolder" name="filter_order_code" placeholder="Sipariş Kodu">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Transfer Yöntemi:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="filter_transfer_method" class="form-select form-select-sm form-select-solid fw-bolder" data-kt-select2="true"
                                            data-placeholder="Seçiniz" data-allow-clear="true">
                                            <option></option>
                                            <option value="UPS">UPS</option>
                                            <option value="BİÇÖZÜM">BiÇözüm</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Sipariş Durumu:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="filter_statu[]" class="form-select form-select-sm form-select-solid fw-bolder" data-kt-select2="true"
                                            data-placeholder="Seçiniz" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                            @foreach ($status as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('bicozumExpress.vorwerkOrderList') }}" class="btn btn-info btn-sm me-2">Tümünü Gör</a>
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
                    </div>
                    <!--end::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Action menu-->
                        <button type="button" class="btn btn-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                            <span class="svg-icon svg-icon-2 me-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->İşlemler
                        </button>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" id="vorwerkImport" data-bs-toggle="modal" data-bs-target="#modal_import">
                                    <span class="indicator-label">
                                        Siparişleri İçe Aktar
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" id="vorwerkExport" data-bs-toggle="modal" data-bs-target="#modal_export">
                                    <span class="indicator-label">
                                        Siparişleri Dışa Aktar
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" id="createUPSCargoCode">
                                    <span class="indicator-label">
                                        UPS Kargo Kodu Oluştur
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" id="printCargoBarcode">
                                    <span class="indicator-label">
                                        Kargo Etiketi Yazdır
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" id="endOfDayBarcode" data-bs-toggle="modal" data-bs-target="#modal_end_of_day_barcode">
                                    Kargoya Teslim Et(Barkod)
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#modal_export_endOfDayReport">
                                    <span class="indicator-label">
                                        Gün Sonu Raporu Al
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" id="synchronizeUPSCargo">
                                    <span class="indicator-label">
                                        Kargo Durum Senkronize
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5" id="synchronizeUPSFreight">
                                    <span class="indicator-label">
                                        UPS Desi Senkronize
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                @if (session('msg'))
                    <div class="alert alert-info">
                        {{ session('msg') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-125px">Sipariş Kodu</th>
                            <th class="w-75px">Oluşturma Tarihi</th>
                            <th class="w-50px">Adet</th>
                            <th class="w-125px">Durum</th>
                            <th class="w-150px">Müşteri</th>
                            <th class="w-200px">Teslimat İl/İlçe</th>
                            <th class="w-50px">Hediye Ürün</th>
                            <th class="w-50px">Transfer Yöntemi</th>
                            <th class="text-end w-75px"><i class="bi bi-eye-fill"></i> / İşlem</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($orders as $item)
                        <tr class="item-{{ $item->id }}">
                            <td>
                                <span role="button" 
                                    class="add-serial-number" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal_add_serial_number" 
                                    data-id="{{ $item->id }}">
                                    <small class="text-info">{{ $item->siparis_kodu }}</small>
                                </span>
                            </td>
                            <td><small class="text-ligth">{{ $item->created_at->format('Y-m-d') }}</small></td>
                            <td><small class="text-info">{{ $item->detail->count() }}</small></td>
                            <td>
                                <div class="badge @if($item->durum == 3) badge-danger @else badge-info @endif"><small>{{ $item->statu->title }}</small></div>
                            </td>
                            <td>
                                <small class="text-gray-600 text-hover-primary mb-1">
                                    @if(!empty($item->teslimat_isim) OR !empty($item->teslimat_soyisim))
                                    {{ mb_strtoupper(@$item->teslimat_isim) . ' ' . mb_strtoupper(@$item->teslimat_soyisim) }}
                                    @else
                                    {{ mb_strtoupper(@$item->consumer->firstName) . ' ' . mb_strtoupper(@$item->consumer->lastName) }}
                                    @endif
                                    <small class="fs-7x text-info d-block">{{ @$item->consumer->phone }}</small>
                                </small>
                            </td>
                            <td class="position-relative bg-light pe-10">
                                <div class="district">
                                    @if(!empty($item->teslimat_il_ups))
                                        <small>{{ $item->ups_il->city_name }}</small>
                                    @else
                                        <small class="text-danger">-</small>
                                    @endif
                                    /
                                    @if(!empty($item->teslimat_ilce_ups))
                                        <small>{{ $item->ups_ilce->area_name }}</small>
                                    @else
                                        <small class="text-danger">-</small>
                                    @endif
                                </div>
                                <div class="position-absolute top-50 end-0 translate-middle-y">
                                    <span type="button" class="btn btn-icon btn-flex btn-active-light-primary w-40px h-40px "
                                        id="update_order_address" data-id="{{ $item->id }}">
                                        <i class="fas fa-pencil-alt fs-1tx"></i>
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if($item->hediye_urun == 1)
                                    <span role="button" class="badge badge-primary update-gift-method" data-id="{{ $item->id }}">Evet</span>
                                @else
                                    <span role="button" class="badge badge-danger update-gift-method" data-id="{{ $item->id }}">Hayır</span>
                                @endif
                            </td>
                            <td>
                                @if(count($item->cargoCodes) == 0)
                                    <span role="button" 
                                        class="badge badge-secondary update-transfer-method" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal_update_transfer_method" 
                                        data-id="{{ $item->id }}">
                                        {{ @$item->transfer_yontemi }}
                                    </span>
                                @else
                                    <small>{{ @$item->transfer_yontemi }}</small>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
                                            <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">İşlemler</div>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link flex-stack order-preview px-3 fs-7" data-id="{{ $item->id }}" >Önizle
                                            <i class="far fa-eye ms-2 fs-7"></i>
                                        </a>
                                    </div>
                                    @if($item->transfer_yontemi == 'UPS')
                                    <div class="menu-item px-3">
                                        <span role="button" class="menu-link px-3 fs-7 createSingleUPSCargoCode"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modal_create_ups_cargo_code" 
                                            data-id="{{ $item->id }}">
                                            UPS Kargo Yönetimi
                                        </span>
                                    </div>
                                    @endif
                                    @if($item->transfer_yontemi == 'BİÇÖZÜM' && ($item->durum == 1 || $item->durum == 5))
                                    <div class="menu-item px-3">
                                        <span role="button" class="menu-link px-3 fs-7 create-transport-request"
                                            data-id="{{ $item->id }}">
                                            Taşıma Talebi Oluştur
                                        </span>
                                    </div>
                                    @endif
                                    <div class="menu-item px-3">
                                        <a href="{{ route('orderTrack', $item->siparis_kodu) }}"
                                            target="_blank"
                                            rel="nofollow noopener"
                                            class="menu-link px-3 fs-7">
                                            Sipariş Takip
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
                {{ $orders->links() }}
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
    <!-- begin:Modal Excel Import -->
    <div class="modal fade" tabindex="-1" id="modal_import">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('bicozumExpress.vorwerkOrderImport') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h3>Excel ile Siparişleri Yükle</h3>
                    </div>
                    <div class="modal-body">
                        <div id="upload">
                            <p class="mb-8">Örnek Excel şablonu için <a href="/sample/ornek_talep_vorwerk.xlsx" target="_self">tıklayınız</a></p>
                            <label for="importFile">Lütfen yüklemek istediğiniz belgeyi seçiniz.</label>
                            <input type="file" id="importFile" class="form-control" name="importFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary" id="modal_excel_import_form_button">
                            <span class="indicator-label">
                                YÜKLE
                            </span>
                            <span class="indicator-progress">
                                Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end:Modal Excel Import -->
    <!-- begin:Modal Excel Import -->
    <div class="modal fade" tabindex="-1" id="modal_export">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('bicozumExpress.vorwerkOrderExport') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h3>Excel ile Siparişleri Dışarı Aktar</h3>
                    </div>
                    <div class="modal-body">
                        <div class="w-100">
                            <div class="row">
                                <div class="col-md-12 fv-row">
                                    <div class="row fv-row fv-plugins-icon-container">
                                        <div class="col-6">
                                            <!--begin::Flatpickr-->
                                            <label for="kt_ecommerce_sales_flatpickr">Başlangıç Tarihi</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-solid rounded rounded-end-0" name="start_date" placeholder="Tarih Seçiniz" id="kt_ecommerce_sales_flatpickr"/>
                                                <button type="button" class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr_clear">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"/>
                                                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                            <!--end::Flatpickr-->
                                        </div>
                                        <div class="col-6">
                                            <!--begin::Flatpickr-->
                                            <label for="kt_ecommerce_sales_flatpickr2">Bitiş Tarihi</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-solid rounded rounded-end-0" name="end_date" placeholder="Tarih Seçiniz" id="kt_ecommerce_sales_flatpickr2"/>
                                                <button type="button" class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr2_clear">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"/>
                                                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                            <!--end::Flatpickr-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary" id="modal_excel_export_form_button">
                            <span class="indicator-label">
                                Dışarı Aktar
                            </span>
                            <span class="indicator-progress">
                                Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end:Modal Excel Import -->
    <!-- begin:Modal Create Order Product Serial Number -->
    <div class="modal fade" tabindex="-1" id="modal_add_serial_number">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body" id="modal_add_serial_number_body">
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:Modal  Order Product Serial Number -->
    <!-- begin:Modal Create Order Product Serial Number -->
    <div class="modal fade" tabindex="-1" id="modal_end_of_day_barcode">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body" id="modal_end_of_day_barcode_body">
                    <div class="card card-flush">
                        <div class="card-body">
                            <div class="position-absolute top-0 start-50 translate-middle">
                                <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                                    <form id="end_of_day_barcode_form">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-1 fw-semibold mb-2">
                                            <span>BARKOD</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control w-500px p-10" placeholder="Lütfen barkodu okutunuz" name="cargo_code" id="cargo_code" required>
                                        <div class="position-absolute me-10 end-0 translate-middle-y me-2 warranty-spinner" style="top:65%; display: none;">
                                            <div class="spinner-border text-info" style="display: block;" role="status">
                                                <span class="visually-hidden">Bekleyiniz...</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:Modal  Order Product Serial Number -->
    <!--begin::VorwerkOrder Export EndOfDay Report Modal-->
    <div class="modal fade" tabindex="-1" id="modal_export_endOfDayReport">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('bicozumExpress.getEndOfDayReport') }}" method="POST" id="export_endOfDayReport" class="px-lg-8">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Vorwerk Siparişleri Gün Sonu Raporunu Dışarı Aktar</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                </svg>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <div class="modal-body">
                        <div class="w-100">
                            <div class="row">
                                <div class="col-md-12 fv-row">
                                    <div class="row fv-row fv-plugins-icon-container">
                                        <div class="col-12">
                                            <!--begin::Flatpickr-->
                                            <label for="kt_ecommerce_sales_flatpickr3">Tarih</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-solid rounded rounded-end-0" name="date" placeholder="Tarih Seçiniz" id="kt_ecommerce_sales_flatpickr3"/>
                                                <button type="button" class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr3_clear">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"/>
                                                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                            <!--end::Flatpickr-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="text-muted fw-semibold fs-6">
                                Devam etmek istiyor musunuz?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary" id="export_endOfDayReport_form_button">
                            <span class="indicator-label">
                                Devam Et
                            </span>
                            <span class="indicator-progress">
                                Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end::VorwerkOrder Export EndOfDay Report Modal-->
    <!-- begin:Modal Update Order Transfer Method -->
    <div class="modal fade" tabindex="-1" id="modal_update_transfer_method">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Yöntemi Düzenle</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body" id="modal_update_transfer_method_body">
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:Modal Update Order Transfer Method -->
    <!--begin::Order Address Update Modal-->
    <div class="modal fade" tabindex="-1" id="update_order_address_modal">
        <div class="modal-dialog">
            <form id="update_order_address_form" class="px-lg-8">
                @csrf
                <input type="hidden" name="orderID">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Müşteri Adresi Bilgilerini Güncelle</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                </svg>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <div class="modal-body">
                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Adres1 <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <textarea type="text" class="form-control"  placeholder="Adres1" name="teslimat_adresi1"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Adres2</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <textarea type="text" class="form-control"  placeholder="Adres2" name="teslimat_adresi2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Adres Tarifi</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <textarea type="text" class="form-control"  placeholder="Adres2" name="teslimat_tarif"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">Posta Kodu</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Adres Adı (Ev, İş, vb)" name="teslimat_posta_kodu">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-lg-3">İl <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <select name="address_city" id="address_city" required class="form-control">
                                        <option>İl Seçiniz</option>
                                        @foreach($cities as $item)
                                            <option value="{{ $item->city_id }}">{{ $item->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">İlçe <span class="required"></span></label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <select name="address_town" id="address_town" required class="form-control">
                                        <option value="">Önce İl Seçiniz</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-primary" id="update_order_address_form_button" data-order-id="">
                            <span class="indicator-label">
                                GÜNCELLE
                            </span>
                            <span class="indicator-progress">
                                Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end::Order Address Update Modal-->
    <!-- begin:Modal Create Order Product Serial Number -->
    <div class="modal fade" tabindex="-1" id="modal_create_ups_cargo_code">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body" id="modal_create_ups_cargo_code_body">
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:Modal  Order Product Serial Number -->
    <!-- begin:Modal Order Cargo Barcode -->
    <div id="modal_order_cargo_barcode" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-2">UPS Kargo Etiketi</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                    fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2"
                                        rx="1"></rect>
                                    <rect fill="#000000" opacity="0.5"
                                        transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                        x="0" y="7" width="16" height="2" rx="1">
                                    </rect>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body d-flex justify-content-center" id="modal_order_cargo_barcode_body"></div>
                <div class="modal-footer" id="modal_order_cargo_barcode_footer">
                    <a class="btn btn-lg btn-light-primary print_order_cargo_barcode"
                        target="_blank"
                        type="button">
                        <i class="bi bi-upc pe-0 fs-3"></i>
                        Yazdır
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:Modal Order Cargo Barcode -->
@endsection

@section('extra_content')
    <div class="modal fade" tabindex="-1" id="show_detail_modal">
        <div class="modal-dialog modal-dialog-centered modal-xl ajax-content">
            {{-- modal content --}}
        </div>
    </div>
    <div id="html_templates" class="d-none">
        <div class="modal-spinners w-100 d-flex justify-content-center align-items-center">
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>
    <script>
        /**
        * Genel Fonksiyon ve Ayarlar
        */
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const element = document.querySelector('#kt_ecommerce_sales_flatpickr');
        flatpickr = $(element).flatpickr({
            allowInput:true,
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d"
        });

        const clearButton = document.querySelector('#kt_ecommerce_sales_flatpickr_clear');
        clearButton.addEventListener('click', e => {
            flatpickr.clear();
        });
        
        const element2 = document.querySelector('#kt_ecommerce_sales_flatpickr2');
        flatpickr2 = $(element2).flatpickr({
            allowInput:true,
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d"
        });

        const clearButton2 = document.querySelector('#kt_ecommerce_sales_flatpickr2_clear');
        clearButton2.addEventListener('click', e => {
            flatpickr2.clear();
        });

        const element3 = document.querySelector('#kt_ecommerce_sales_flatpickr3');
        flatpickr3 = $(element3).flatpickr({
            allowInput:true,
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d"
        });

        const clearButton3 = document.querySelector('#kt_ecommerce_sales_flatpickr3_clear');
        clearButton3.addEventListener('click', e => {
            flatpickr3.clear();
        });

        // input Mask
        Inputmask({
            "mask" : "(999) 999-9999",
            "placeholder": "(___) ___-____",
        }).mask("#filter_consumer_phone");

        $(document).on('click', '#modal_excel_import_form_button', function () {
            let button = $(this);
            button.attr("data-kt-indicator", "on");
        });

        $(document).on('click', '#synchronizeUPSCargo', function () {
            let button = $(this);
            button.attr("data-kt-indicator", "on");
            window.location.href = "{{ route('bicozumExpress.synchronizeUPSCargo') }}";
        });
        
        $(document).on('click', '#synchronizeUPSFreight', function () {
            let button = $(this);
            button.attr("data-kt-indicator", "on");
            window.location.href = "{{ route('bicozumExpress.synchronizeUPSFreight') }}";
        });
        
        $(document).on('click', '#createUPSCargoCode', function () {
            Swal.fire({
                title: 'Emin misiniz?',
                text: "Siparişler için kargo kodu oluşturulduktan sonra müşteriye SMS bildirimi yapılacaktır.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7239ea',
                cancelButtonColor: '#f1416c',
                confirmButtonText: 'Evet, onaylıyorum.',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let button = $(this);
                    button.attr("data-kt-indicator", "on");
                    window.location.href = "{{ route('bicozumExpress.createUPSCargoCode') }}";
                }
            });
        });

        $(document).on('click', '#printCargoBarcode', function () {
            Swal.fire({
                title: 'Emin misiniz?',
                text: "Siparişler için kargo barkod etiketi yazdırılıcaktır. Emin misiniz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7239ea',
                cancelButtonColor: '#f1416c',
                confirmButtonText: 'Evet, onaylıyorum.',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let button = $(this);
                    button.attr("data-kt-indicator", "on");
                    window.open("{{ route('bicozumExpress.printCargoBarcode') }}", "_blank");
                }
            });
        });

        $(document).on('click', '.cargo_barcode', function() {
            let cargo_code = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "{{ route('bicozumExpress.printCargoBarcode') }}",
                data: {
                    cargo_code: cargo_code
                },
                success: function (data) {
                    $("#modal_order_cargo_barcode").modal('show');
                    $("#modal_order_cargo_barcode #modal_order_cargo_barcode_body").html(data);
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                }
            });
        });
        
        $('.print_order_cargo_barcode').on('click', function() {
            $("#modal_order_cargo_barcode #modal_order_cargo_barcode_body #printable_barcode").print();
        });

        $(document).on('click', '.add-serial-number', function (event) {
            event.preventDefault();
            let order_id = $(this).data('id');
            let button = $(this);

            $.ajax({
                type: "GET",
                url: "{{ route('bicozumExpress.vorwerkOrderAddSerialNumber') }}",
                data: {
                    order_id: order_id
                },
                success: function (response, textStatus, xhr) {
                    $('#modal_add_serial_number').modal("show");
                    $('#modal_add_serial_number_body').html(response).show();
                }
            });
        });

        $(document).on('click', '.createSingleUPSCargoCode', function (event) {
            event.preventDefault();
            let order_id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "{{ route('bicozumExpress.createUPSCargoCode') }}",
                data: {
                    order_id: order_id
                },
                success: function (response, textStatus, xhr) {
                    $('#modal_create_ups_cargo_code').modal("show");
                    $('#modal_create_ups_cargo_code_body').html(response).show();
                }
            });
        });

        $(document).on('submit', '#barcode_form', function (event) {
            let serial_code = $("#serial_code").val();
            let order_id = $("#order_id").val();
            $('.warranty-spinner').show();
            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.vorwerkOrderSaveSerialNumber') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    serial_code: serial_code,
                    order_id: order_id
                },
                success: function (data) {
                    if (data == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Bu sipariş için işlem yapamazsınız!'
                        });
                        $('.warranty-spinner').hide();
                    } else {
                        $("#barcode_form")[0].reset();
                        $('.warranty-spinner').hide();
                        $('#modal_add_serial_number').modal("hide");
                        toastr.success("Ürün seri numarası başarıyla kaydedilmiştir.");
                    }
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                }
            });
            event.preventDefault();
        });

        $(document).on('submit', '#end_of_day_barcode_form', function (event) {
            let cargo_code = $("#cargo_code").val();
            $('.warranty-spinner').show();
            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.vorwerkOrderShipUpsCargoCode') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    cargo_code: cargo_code
                },
                success: function (data) {
                    if (data == 'exist') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Bu kargo numarası işlem görmüştür!'
                        });
                        $('.warranty-spinner').hide();
                    } else if (data == 'emptySerial') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Bu sipariş için seri numarası bilgisi eksik!'
                        });
                        $('.warranty-spinner').hide();
                    } else {
                        $("#end_of_day_barcode_form")[0].reset();
                        $('.warranty-spinner').hide();
                        toastr.success("İşlem başarıyla gerçekleştirilmiştir!");
                    }
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                }
            });
            event.preventDefault();
        });
        
        $(document).on('click', '#create_ups_cargo_code_form_button', function (event) {
            button = $(this);
            button.attr("data-kt-indicator", "on");
        });
        
        $(document).on('click', '.serial_remove', function (event) {
            let serial_code = $(this).data('serial');
            let order_id = $(this).data('id');
            
            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.vorwerkOrderRemoveSerialNumber') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    serial_code: serial_code,
                    order_id: order_id
                },
                success: function (data) {
                    $('#modal_add_serial_number').modal("hide");
                    toastr.success("Ürün seri numarası başarıyla silinmiştir.");
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                }
            });
        });

        $(document).on('click', '.cargoCode_remove', function (event) {
            let cargo_code = $(this).data('id');

            Swal.fire({
                title: 'Emin misiniz?',
                text: "Hediye ürün bilgisini güncelleyeceksiniz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7239ea',
                cancelButtonColor: '#f1416c',
                confirmButtonText: 'Evet, onaylıyorum.',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
            
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.vorwerkOrderRemoveCargoCode') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            cargo_code: cargo_code
                        },
                        success: function (data) {
                            $('#modal_create_ups_cargo_code').modal("hide");
                            toastr.success("Sipariş kargo numarası başarıyla silinmiştir.");
                        },
                        error: function(jqXHR, testStatus, error) {
                            console.log(error);
                            alert("Hata:" + error);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.update-gift-method', function () {
            let order_id = $(this).data('id');
            let button = $(this);

            Swal.fire({
                title: 'Emin misiniz?',
                text: "Hediye ürün bilgisini güncelleyeceksiniz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7239ea',
                cancelButtonColor: '#f1416c',
                confirmButtonText: 'Evet, onaylıyorum.',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.vorwerkOrderUpdateGiftMethod') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id: order_id
                        },
                        success: function (response) {
                            if (response) {
                                Swal.fire(
                                    'Tebrikler!',
                                    'İşlem gerçekleştirildi',
                                    'success'
                                ).then(function () {  
                                    let giftMethod = response;
                                    if (giftMethod == 'Evet') {
                                        button.removeClass('badge-danger');
                                        button.addClass('badge-primary');
                                    } else {
                                        button.removeClass('badge-primary');
                                        button.addClass('badge-danger');
                                    }
                                    button.html('');
                                    button.html(giftMethod);
                                });
                            } else {
                                Swal.fire(
                                    'Hata!',
                                    'Bir sorun oluştu.',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.update-transfer-method', function (event) {
            event.preventDefault();
            let order_id = $(this).data('id');
            let button = $(this);

            $.ajax({
                type: "GET",
                url: "{{ route('bicozumExpress.vorwerkOrderEditTransferMethod') }}",
                data: {
                    order_id: order_id
                },
                success: function (response, textStatus, xhr) {
                    $('#modal_update_transfer_method').modal("show");
                    $('#modal_update_transfer_method_body').html(response).show();
                }
            });
        });

        $(document).on('click', '.order-preview', function() {
            let dataID = $(this).data('id');

            let spinner = $('#html_templates .modal-spinners').clone();

            $('#show_detail_modal .ajax-content').html(spinner);
            $('#show_detail_modal').modal('show');

            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.vorwerkOrderPreview') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: dataID
                },
                success: function(response) {
                    $('#show_detail_modal .ajax-content').fadeOut(250, function() {
                        $(this).html(response).fadeIn(250);
                    });
                }
            });
        });

        $(document).on('click', '#rejectTheOrder', function() {
            let orderID = $(this).data('id');

            $(this).attr("data-kt-indicator", "on");
            
            Swal.fire({
                title: 'Emin misiniz?',
                text: "Siparişi reddetmek üzeresiniz, emin misiniz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7239ea',
                cancelButtonColor: '#f1416c',
                confirmButtonText: 'Evet, onaylıyorum.',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.vorwerkOrderReject') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: orderID
                        },
                        success: function(response) {
                            if (response) {
                                $('#show_detail_modal').modal('hide');
                                $(this).removeAttr("data-kt-indicator");
                                toastr.success("Sipariş iptal edildi.");
                                location.reload();
                            } else {
                                toastr.error("Bir hata oluştu");
                                $(this).removeAttr("data-kt-indicator");
                            }
                        }
                    });
                }
            });
        });

        // Sipariş Adresi Bilgilerini Güncelle
        $(document).on('click', '#update_order_address', function () {
            let orderID = $(this).data('id');

            $('#update_order_address_form textarea[name="teslimat_adresi1"]').text('');
            $('#update_order_address_form textarea[name="teslimat_adresi2"]').text('');
            $('#update_order_address_form textarea[name="teslimat_tarif"]').text('');
            $('#update_order_address_form input[name="teslimat_posta_kodu"]').val('');
            $('#update_order_address_form select[name="address_city"]').val('');
            $('#update_order_address_form select[name="address_town"]').val('');

            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.vorwerkOrderGetSelectedAddress') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    orderID: orderID
                },
                success: function (response) {
                    if (response) {
                        $('#update_order_address_form input[name="orderID"]').val(response.id);
                        $('#update_order_address_form textarea[name="teslimat_adresi1"]').val(response.teslimat_adresi1);
                        $('#update_order_address_form textarea[name="teslimat_adresi2"]').val(response.teslimat_adresi2);
                        $('#update_order_address_form textarea[name="teslimat_tarif"]').val(response.teslimat_tarif);
                        $('#update_order_address_form input[name="teslimat_posta_kodu"]').val(response.teslimat_posta_kodu);
                        $('#update_order_address_form select[name="address_city"]').val(response.teslimat_il_ups).change();
                        getTowns(response.teslimat_il_ups, '#update_order_address_form select[name="address_town"]', response.teslimat_ilce_ups);
                        $('#update_order_address_form_button').data('order-id', response.id);
                    }
                }
            }).done(function(){
                $('#update_order_address_modal').modal('toggle');
            });
        });

        //Sipariş Adresi Güncelle
        $(document).on('click', '#update_order_address_form_button', function () {
            let form = $('#update_order_address_form');
            let formData = form.serializeArray();
            button = $(this);
            button.attr("data-kt-indicator", "on");
            let orderID = button.data('order-id');

            form.validate({
                errorPlacement: function(){
                    return false;
                },
            });
            if (form.valid()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('bicozumExpress.vorwerkOrderUpdateAddress') }}",
                    data: formData,
                    success: function (response) {
                        if(response) {
                            console.log(response);
                            button.removeAttr("data-kt-indicator");
                            $('#update_order_address_modal').modal('hide');
                            toastr.success('Tebrikler! Sipariş adres kaydı güncellenmiştir.');
                            form.trigger("reset");

                            $('.item-'+orderID+' .district').html('<small>'+response.city_name+'</small>/<small>'+response.area_name+'</small>')
                        }
                    }
                });
            } else {
                button.removeAttr('data-kt-indicator');
                Toast.fire({
                    icon: 'error',
                    title: 'Lütfen tüm alanları eksiksiz doldurun.',
                    position: 'center'
                });
            }
        });

        //Müşteri Adresi Güncelle Formu - İlçeler
        $(document).on('change', '#update_order_address_form select[name="address_city"]', (arguments) => {
            let city = $('#update_order_address_form select[name="address_city"]').val();
            getTowns(city, '#update_order_address_form select[name="address_town"]');
        });

        //AJAX  İlçeler
        function getTowns(city, resultDiv, selected) { 
            $.ajax({
                type: "post",
                url: "{{ route('bicozumExpress.upsTowns') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'city_id': city
                },
                success: function (response) {
                    if (response) {
                        let html = '<option value="">Seçiniz</value>';
                        response.map((item) => {
                            html += `<option value="${item.area_id}" ${ item.area_id == selected ? 'selected' : '' }>${item.area_name}</option>`;
                        })
                        $(resultDiv).html(html);
                    }
                }
            });
        }
    </script>
    <script>
        $(document).on('click', '.create-transport-request', function () {
            let orderID = $(this).data('id');

            Swal.fire({
                title: 'Taşıma Talebi Oluştur',
                text: "BiÇözüm taşıma talebi luşturulacak onaylıyor musunuz?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#7239ea',
                cancelButtonColor: '#f1416c',
                confirmButtonText: 'Evet.',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.vorwerkCreateTransportRequest') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id: orderID,
                        },
                        success: function (response, text, xhr) {
                            console.log(xhr.status);
                            if (xhr.status == 200) {
                                Swal.fire({
                                    text: "Tebrikler! Taşıma talebi oluşturuldu",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                                // location.reload();
                            }
                        },
                        statusCode: {
                            500: function() {
                                Swal.fire({
                                    text: "Bir Sorun Oluştu",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection