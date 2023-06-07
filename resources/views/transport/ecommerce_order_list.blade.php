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
                                <a href="#" class="menu-link px-5" id="ecommerceImport" data-bs-toggle="modal" data-bs-target="#modal_import">
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
                                <a href="#" class="menu-link px-5" id="synchronizeECommerce">
                                    <span class="indicator-label">
                                        Siparişleri Horoza Aktar
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
                            <th class="w-50px">Sipariş Kodu</th>
                            <th class="w-150px">Durum</th>
                            <th class="w-50px">Oluşturma Tarihi</th>
                            <th class="w-50px">Adet</th>
                            <th class="w-150px">Müşteri</th>
                            <th class="w-200px">Teslimat İl/İlçe</th>
                            <th class="text-end w-75px"><i class="bi bi-eye-fill"></i> / İşlem</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($orders as $item)
                        <tr class="item-{{ $item->id }}">
                            <td><small class="text-info">{{ $item->siparis_no }}</small></td>
                            <td>
                                <div class="badge badge-info">
                                    <small>{{ ($item->durum == 1) ? 'Sipariş Alındı' : 'Aktarım Tamamlandı' }}</small>
                                </div>
                            </td>
                            <td><small class="text-ligth">{{ $item->created_at->format('Y-m-d') }}</small></td>
                            <td><small class="text-info">{{ $item->detail->count() }}</small></td>
                            <td>
                                <small class="text-gray-600 text-hover-primary mb-1">
                                    {{ mb_strtoupper(@$item->musteri_kodu) }} <br>
                                    {{ mb_strtoupper(@$item->musteri) }} <br>
                                    <small class="fs-7x text-info d-block">{{ @$item->tel }}</small>
                                </small>
                            </td>
                            <td>
                                <div class="district">
                                    <small>{{ $item->il }}</small>
                                    /
                                    <small>{{ $item->ilce }}</small>
                                </div>
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
                <form method="POST" action="{{ route('bicozumExpress.ecommerceOrderImport') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h3>Excel ile Siparişleri Yükle</h3>
                    </div>
                    <div class="modal-body">
                        <div id="upload">
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

        $(document).on('click', '#modal_excel_import_form_button', function () {
            let button = $(this);
            button.attr("data-kt-indicator", "on");
        });

        $(document).on('click', '#synchronizeECommerce', function () {
            let button = $(this);
            button.attr("data-kt-indicator", "on");
            window.location.href = "{{ route('bicozumExpress.synchronizeECommerceOrder') }}";
        });

        $(document).on('click', '.order-preview', function() {
            let dataID = $(this).data('id');

            let spinner = $('#html_templates .modal-spinners').clone();

            $('#show_detail_modal .ajax-content').html(spinner);
            $('#show_detail_modal').modal('show');

            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.ecommerceOrderPreview') }}",
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
    </script>
@endsection
