@extends('common.layout')
@php
    function getProduct($id)
    {
        $a = @App\Models\Product::select('product_name')
            ->where('id', $id)
            ->first();
        return @$a->product_name;
    }
@endphp
@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-center flex-wrap py-8">
                    <!--begin::store-->
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-info p-3 me-2">{{ $return->id }}</span>
                            <span class="text-gray-700 fs-2 fw-bold me-1">Talep Bilgileri</span>
                        </div>
                    </div>
                    <!--end::store-->
                </div>
                <!--end::Title-->
            </div>
            <div class="card-body pt-9 pb-0">
                <div class="row mb-12">
                    <div class="col-lg-6">
                        <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                            <!--begin::Underline-->
                            @if($return->consumer_id != 0)
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
                                    <span class="d-block">{{ $return->consumer->firstName }} {{ $return->consumer->lastName }}</span>
                                    <span class="d-block">{{ $return->consumer->email }}</span>
                                    <span class="d-block">{{ $return->consumer->phone }}</span>
                                </div>
                            @else
                                <!--begin::Underline-->
                                <span class="d-inline-block position-relative mb-4">
                                    <span class="d-inline-block mb-1 fs-5">
                                        Mağaza Bilgileri
                                    </span>
                                    <span
                                        class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                </span>
                                <!--end::Underline-->
                                <div class="d-block align-items-center">
                                    <span class="d-block">{{ $return->store->musteri_kodu.' - '.$return->store->name }}</span>
                                    <span class="d-block">{{ $return->store->telefon }}</span>
                                    <span class="d-block">{{ $return->store->adres }}</span>
                                    <span class="d-block">{{ $return->store->il.' - '.$return->store->ilce }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
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
                                        {{ $return->created_at->format('d-m-Y H:i') }}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <!--begin::Underline-->
                                    <span class="d-inline-block position-relative mb-4">
                                        <span class="d-inline-block mb-1 fs-5">
                                            Talep Tip
                                        </span>
                                        <span
                                            class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                    </span>
                                    <!--end::Underline-->
                                    <div class="d-block align-items-center">
                                        @if($return->tip == 1)
                                            <span class="badge badge-info p-3 me-2">İADE</span>
                                        @elseif($return->tip == 3)
                                            <span class="badge badge-info p-3 me-2">DEĞİŞİM</span>
                                        @else
                                            <span class="badge badge-info p-3 me-2">İPTAL</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    @if (isset($return->refundOrderNumber))
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
                                            {{ $return->refundOrderNumber }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('msg'))
                    <div class="alert alert-info">
                        {{ session('msg') }}
                    </div>
                @endif
                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold ps-4">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active"
                            data-bs-toggle="tab" href="#kt_tab_pane_1">
                            İade Detayı
                        </a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0"
                            data-bs-toggle="tab" href="#kt_tab_pane_2">
                            Log
                        </a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="kt_tab_pane_1" role="tabpanel">
                        <div class="table border rounded p-8">
                            <table id="kt_datatable_example_5" class="table table-striped gy-5 gs-7 rounded">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th><i class="bi bi-card-checklist"></i></th>
                                        <th>Detay Kodu</th>
                                        <th>Ürün Kodu</th>
                                        <th>Ürün Adı</th>
                                        <th>İade Sebebi</th>
                                        <th>Arıza Notu</th>
                                        <th>Revizyon</th>
                                        <th class="text-center"><i class="bi bi-menu-button-wide-fill"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($return->details as $item)
                                        <tr class="align-middle"
                                            @if (($item->iade_durumu == 1 and $item->ayristirma_id != null) or $item->iade_durumu == 2 or $item->iade_durumu == 3 or $item->degisim_durumu == 1 or $item->degisim_durumu == 2) style="color:#000" @else style="color:#ff0000" @endif>
                                            <td><span class="text-info">{{ $say }}</span></td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->product_code }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>
                                                <span class="badge badge-light-info">
                                                    {{ $item->return_reason }}
                                                </span>
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
                                            <td>{{ $item->ariza }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light-info fw-bold fs-8 py-1 px-3"
                                                    onclick="action('{{ $item->id }}')">
                                                    {{ $item->revizyon_product_id ? $item->revizyon_product_id . ' - ' . getProduct($item->revizyon_product_id) : 'Revizyon' }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="#"
                                                    class="btn btn-sm btn-light-info border border-info ayristirilanUrun"
                                                    data-return="{{ $return->id }}-{{ $item->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#modal_ayristir">
                                                    İncele
                                                </a>
                                            </td>
                                        </tr>
                                        @php $say++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        @if(count($return->logs) > 0)
                            @include('components.logs')
                        @else
                            <div class="border rounded p-5">
                                <span class="fs-5 text-info fw-bold me-1">Bu iadeye bağlı herhangi bir işlem gerçekleştirilmemiştir.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                @if ($tamam)
                    <a href="#" class="btn btn-md btn-info me-3" data-bs-toggle="modal"
                        data-bs-target="#modal_onayla">Kontrol Tamamlandı</a>
                @else
                    <a href="#" class="btn btn-md btn-info me-3">Kontrol Tamamlanmadı</a>
                @endif
            </div>
        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Container-->
@endsection

@section('extra_content')
    <div id="modal_ayristir" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
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
                <div class="modal-body">
                    @include('returns.repair.inc.ayristirma')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_onayla" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        action="{{ route('returns.repair.approve') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">İade Tamir Onayı</h1>
                        </div>
                        <div class="d-flex flex-column mb-5">
                            <textarea class="form-control form-control-solid" rows="4" name="note_onay" placeholder="Onay Notu"></textarea>
                        </div>
                        <div class="mb-13">
                            <div class="text-muted fw-semibold fs-6">
                                İade tamir onayı vermek üzeresiniz, Bu işleme devam etmek istediğinizden emin misiniz?
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="hidden" value="{{ $return->id }}" name="return_id" id="return_id">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                            <button type="submit" id="modal_onayla_submit" class="btn btn-primary">
                                <span class="indicator-label">Evet</span>
                                <span class="indicator-progress">
                                    Lütfen Bekleyiniz...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_revizyon" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-body">
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                        rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                        <form>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="required fs-6 text-gray-700 ms-1 mb-3">Ürün Seç</label>
                                <input type="hidden" name="detay" id="detay">
                                <input type="text" name="ara" id="ara" class="form-control mb-7"
                                    oninput="searchProduct();" placeholder="Ürün Ara...">
                                <small class="d-flex ms-1 text-muted" id="sonuc">
                                    <i class="bi bi-info-circle-fill text-gray-600 fs-4 me-2"></i>En az 4 karakter girerek
                                    arama yapabilirsiniz.
                                </small>
                            </div>
                        </form>
                    </div>
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
                <div class="modal-body d-flex justify-content-center" id="modal_product_barcode_body"></div>
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
        function action(detay) {
            document.getElementById('detay').value = detay;
            document.getElementById("ara").focus();
            $('#modal_revizyon').modal('show');
        }

        function searchProduct() {
            var data = document.getElementById('ara').value;
            var detay = document.getElementById('detay').value;
            var n = data.length;
            if (n > 3) {
                document.getElementById("sonuc").innerHTML = "";
                $.ajax({
                    type: 'GET',
                    url: "{{ route('searchProduct') }}",
                    data: {
                        data: data,
                        detay: detay
                    },
                    success: function(data) {
                        document.getElementById("sonuc").innerHTML = data;
                    }
                });
            }
        }

        function revizyon(id, rev) {
            if (id > 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('revizyon') }}",
                    data: {
                        id: id,
                        rev: rev
                    },
                    success: function(data) {
                        $(".productname_" + id).html(data['product_name']);
                        $(".productcode_" + id).html(data['product_code']);
                    }
                });
                document.getElementById('ara').value = "";
                document.getElementById('detay').value = "";
                document.getElementById("sonuc").innerHTML = "";
                $('#modal_revizyon').modal('hide');
                location.reload();
            }
        }
    </script>
    <script>
        let url = "{{ route('returns.repair.product_barcode', '') }}";
        $(document).ready(function() {
            localStorage.clear();

            $(".ayristirilanUrun").click(function() {
                var return_id = $(this).attr('data-return');

                $.ajax({
                    type: 'GET',
                    url: "{{ route('returns.repair.action') }}",
                    data: {
                        return_id: return_id
                    },
                    success: function(data) {
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
                    }
                });
            });
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
            $("#modal_product_barcode #modal_product_barcode_body #printable_barcode").print();
        });
    </script>
@endsection
