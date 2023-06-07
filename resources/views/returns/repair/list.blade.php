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
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Taleplerde Ara" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            @if (session('msg'))
                <div class="alert alert-info">
                    {{ session('msg') }}
                </div>
            @endif
            <div class="position-absolute top-0 start-50 translate-middle">
                <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                    <form action="#" id="barcode_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" >
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-1 fw-semibold mb-2 text-light">
                            <span>BARKOD</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" class="form-control w-500px p-10" placeholder="Lütfen barkodu okutunuz" name="return_barcode" id="return_barcode">
                        <div class="position-absolute me-10 end-0 translate-middle-y me-2 warranty-spinner" style="top:65%; display: none;">
                            <div class="spinner-border text-info" style="display: block;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-30px">Talep Kodu</th>
                        <th class="min-w-150px">Talep Etiketi</th>
                        <th class="min-w-150px">Sipariş Numarası</th>
                        <th class="min-w-150px">Tüketici</th>
                        <th class="min-w-50px">Talep Tarihi</th>
                        <th class="min-w-30px">Ürün Adedi</th>
                        <th class="text-end min-w-70px">Actions</th>
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
                            <span class="text-info">#{{ $item->id }}</span>
                        </td>
                        <td>
                            <small class="badge badge-primary">{{ $item->line_type }}</small>
                        </td>
                        <td>{{ $item->order_number }}</td>
                        <td>{{ $item->store_name}} - {{ $item->customer }}</td>
                        <td>
                            <small>{{ $item->created_at->format('d.m.Y H:i') }}</small>
                        </td>
                        <td>
                            {{ $item->adet }}
                        </td>
                        <!--begin::Action=-->
                        <td class="text-end text-center">
                            <a href="{{ ($item->type == 'iade_talebi' or $item->type == 'degisim_talebi') ? route('returns.repair.detail', $item->id) : route('service.technical_analysis_detail', $item->id) }}" class="btn btn-sm btn-light-primary btn-active-light-info">İşlem</a>
                        </td>
                        <!--end::Action=-->
                    </tr>
                    @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Category-->
</div>
<!--end::Container-->
@endsection
@section('extra_content')
<div id="modal_ayristir" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">Tamir Yapılan Ürün</h5>
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
            <div class="modal-body" id="modal_ayristir_body">
                @include('returns.repair.inc.ayristirma')
            </div>
        </div>
    </div>
</div>
<div id="modal_product_barcode" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">Ürün Barkodu</h5>
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
            <div class="modal-body d-flex justify-content-center" id="modal_product_barcode_body">
            </div>
            <div class="modal-footer" id="modal_product_barcode_footer">
                <a class="btn btn-lg btn-light-primary print_product_barcode"
                    target="_blank"
                    type="button">
                    <i class="bi bi-upc pe-0 fs-3"></i>
                    Yazdır
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
<style>
    pre {
        white-space: pre-wrap;       /* css-3 */
        white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
        white-space: -pre-wrap;      /* Opera 4-6 */
        white-space: -o-pre-wrap;    /* Opera 7 */
        word-wrap: break-word;       /* Internet Explorer 5.5+ */
    }
</style>
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <!--end::Vendors Javascript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>
    <script>
        let url = "{{ route('returns.repair.product_barcode', '') }}";
        $("#barcode_form").submit(function (event) {
            let return_barcode = $("#return_barcode").val();
            $('.warranty-spinner').show();
            $.ajax({
                type: "POST",
                url: "{{ route('returns.repair.barcode_action') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    return_barcode: return_barcode
                },
                success: function (data) {
                    $('.warranty-spinner').hide();
                    $('#modal_ayristir').modal("show");
                    $('#return_detail_id').val(data.return_detail_id);
                    $('input[name="return_id"]').val(data.return_id);
                    $('.return_id').text(data.return_id);
                    document.getElementById('product_name').innerHTML = data.product_name;
                    document.getElementById('product_code').innerHTML = data.product_code;
                    if (data.type == 1) {
                        $('.returnText').removeClass('d-none');
                        $('.returnSelection').removeClass('d-none');
                    } else {
                        $('.changeText').removeClass('d-none');
                        $('.changeSelection').removeClass('d-none');
                    }
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                }
            });

            event.preventDefault();
        });
        $('input[type=radio][name=plan]').on('change', function() {
            if (this.value == 3 || this.value == 2) {
                $('#ayristirma').hide();
            } else {
                $('#ayristirma').show();
            }
        });
        $('input[type=radio][name=plan], select[name=ayristirma_id]').on('change', function() {
            let plan = $("input[name='plan']:checked").val();
            let ayristirma_id = $('select[name=ayristirma_id]').val();

            if (plan == 1) {
                if (ayristirma_id != 0) {
                    $('.product_barcode').removeClass('d-none');
                } else {
                    $('.product_barcode').addClass('d-none');
                }
            } else {
                $('.product_barcode').addClass('d-none');
            }
        });
        $('select[name=ayristirma_id]').on('change', function() {
            let ayristirmaID = $(this).val();
            $('.product_barcode').attr('data-ayristirma-id', ayristirmaID);
        });
        $('.product_barcode').on('click', function() {
            let ayristirma_id = $(this).attr('data-ayristirma-id');
            let detail_id = $('#return_detail_id').val();
            let route = url + '/' + detail_id + '?ayristirma_id=' + ayristirma_id;

            $.ajax({
                type: "GET",
                url: route,
                success: function (data) {
                    if (data == 0) {
                        toastr.error("Seçilen ayrıştırma durumuna bağlı ürün kartı bulunmamaktadır.");
                        $(".ayritirmaSubmitButton").attr('disabled','disabled');
                    } else {
                        $("#modal_product_barcode").modal('show');
                        $("#modal_product_barcode #modal_product_barcode_body").html(data);
                        $(".ayritirmaSubmitButton").removeAttr('disabled','disabled');
                    }
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Hata:" + error);
                }
            });
        });

        $('.print_product_barcode').on('click', function() {
            $("#modal_product_barcode #modal_product_barcode_body").print();
        });
    </script>
@endsection
