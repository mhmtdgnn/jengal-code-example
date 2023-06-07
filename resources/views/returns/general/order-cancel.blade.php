@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Category-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
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
                        <div class="menu menu-sub menu-sub-dropdown w-350px w-md-350px" data-kt-menu="true"
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
                                        <label class="form-label fs-7 fw-bold mb-3">Talep Kodu:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid fw-bolder" name="filter_return_id" placeholder="Talep Kodu">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Sipariş No:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid fw-bolder" name="filter_order_code" placeholder="Sipariş No">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fs-7 fw-bold mb-3">Ürün:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="filter_product[]" class="form-select form-select-sm form-select-solid fw-bolder product-select" multiple="multiple">
                                            <option></option>
                                            @foreach ($products as $item)
                                                <option value="{{ $item->id }}">{{ $item->product_code.'-'.$item->product_name }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('returns.orderCancel') }}" class="btn btn-info btn-sm me-2">Tümünü Gör</a>
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
                        <!--begin::Add customer-->
                        {{-- <a href="{{ route('returns.create') }}" class="btn btn-primary">Talep Oluştur</a> --}}
                        <!--end::Add customer-->
                    </div>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">Talep Kodu</th>
                            <th class="min-w-50px">Sipariş No</th>
                            <th class="min-w-150px">Talep Durumu</th>
                            <th class="min-w-150px">Detaylar</th>
                            <th class="text-center min-w-50px">Ürün Adedi</th>
                            <th class="text-center min-w-70px">Actions</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-semibold text-gray-600">
                        <!--begin::Table row-->
                        @foreach ($returns as $item)
                            <tr>
                                <td>
                                    <span class="text-dark">#{{ $item->id }}</span>
                                </td>
                                <td>
                                    <small class="text-info">{{ $item->refundOrderNumber }}</small>
                                </td>
                                <td>
                                    <div class="badge badge-info">{{ config('sebportal.magaza_durumlar.' . $item->status) }}
                                    </div>
                                </td>
                                <td>
                                    <small>
                                        <span class="text-info">Talep Tarihi : </span> <span
                                            class="text-muted">{{ $item->created_at->format('d.m.Y H:i') }}</span> <br>
                                        <span class="text-primary">Son Güncelleme : </span> <span
                                            class="text-muted">{{ $item->updated_at->format('d.m.Y H:i') }}</span> <br>
                                        @if ($item->consumer_id == 0)
                                            <span class="text-dark">Mağaza : </span> <span
                                                class="text-muted">{{ $item->store->name }}</span>
                                        @else
                                            <span class="text-dark">Müşteri : </span> <span class="text-muted">
                                                {{ $item->consumer->firstName ?? '' }} {{ $item->consumer->lastName ?? '' }}
                                            </span>
                                        @endif
                                    </small>
                                </td>
                                <td class="text-center">{{ $item->adet }}</td>
                                <!--begin::Action=-->
                                <td class="text-center">
                                    <span data-id="{{ $item->id }}"
                                        class="btn btn-sm btn-light-primary btn-active-light-info request-detail">
                                        İncele
                                    </span>
                                </td>
                                <!--end::Action=-->
                            </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
                {{ $returns->links() }}
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Category-->
    </div>
    <!--end::Container-->
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
    <script>
        $('.product-select').select2({
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Seçiniz',
            language: { inputTooShort: function () { return "Lütfen en az 2 karakter giriniz.."; } }
        });

        $(document).on('click', '.request-detail', function() {
            let dataID = $(this).data('id');

            let spinner = $('#html_templates .modal-spinners').clone();

            $('#show_detail_modal .ajax-content').html(spinner);
            $('#show_detail_modal').modal('show');

            $.ajax({
                type: "POST",
                url: "{{ route('returns.general.detail') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: dataID,
                    action_type: 'cancel'
                },
                success: function(response) {
                    $('#show_detail_modal .ajax-content').fadeOut(250, function() {
                        $(this).html(response).fadeIn(250);
                    });
                    setTimeout(function(){
                        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
                    },550); 
                }
            });
            // toastr.error("Özellik Hazırlanıyor");
        });

        $(document).on('click', '#convertToRefundRequest', function() {
            let dataID = $(this).data('id');

            $(this).attr("data-kt-indicator", "on");

            $.ajax({
                type: "POST",
                url: "{{ route('returns.orderCancelConvertToReturn') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: dataID
                },
                success: function(response) {
                    if (response) {
                        $('#show_detail_modal').modal('hide');
                        $(this).removeAttr("data-kt-indicator");
                        toastr.success("Talep iade talebine dönüştürüldü.");
                        location.reload();
                    } else {
                        toastr.error("Bir hata oluştu");
                        $(this).removeAttr("data-kt-indicator");
                    }
                }
            });
        });

        $(document).on('click', '#acceptTheRequest', function() {
            let dataID = $(this).data('id');

            $(this).attr("data-kt-indicator", "on");

            $.ajax({
                type: "POST",
                url: "{{ route('returns.orderCancelConfirm') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: dataID
                },
                success: function(response) {
                    if (response) {
                        $('#show_detail_modal').modal('hide');
                        $(this).removeAttr("data-kt-indicator");
                        toastr.success("Talep kabul edildi.");
                        location.reload();
                    } else {
                        toastr.error("Bir hata oluştu");
                        $(this).removeAttr("data-kt-indicator");
                    }
                }
            });
        });

        $(document).on('click', '#rejectTheRequest', function() {
            let dataID = $(this).data('id');

            $(this).attr("data-kt-indicator", "on");

            $.ajax({
                type: "POST",
                url: "{{ route('returns.orderCancelReject') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: dataID
                },
                success: function(response) {
                    if (response) {
                        $('#show_detail_modal').modal('hide');
                        $(this).removeAttr("data-kt-indicator");
                        toastr.success("Talep iptal edildi.");
                        location.reload();
                    } else {
                        toastr.error("Bir hata oluştu");
                        $(this).removeAttr("data-kt-indicator");
                    }
                }
            });
        });
    </script>
@endsection
