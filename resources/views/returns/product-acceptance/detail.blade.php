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
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <style type="text/css">
        #results {
            height: 350px;
            padding: 20px;
        }

        #results img {
            width: 350px;
            height: 265px;
        }
    </style>
@endsection
@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-center w-100 py-6">
                    <!--begin::store-->
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-info p-3 me-2">{{ $return->id }}</span>
                            <span class="text-gray-700 fs-2 fw-bold me-1">Mağaza ve Talep Bilgileri</span>
                        </div>
                    </div>
                    <!--end::store-->
                    <div class="d-flex">
                        <span class="btn btn-md btn-info px-8 me-3" data-bs-toggle="modal" data-bs-target="#modal_onayla">
                            KONTROLÜ TAMAMLA
                        </span>
                    </div>
                </div>
                <!--end::Title-->
            </div>
            <div class="card-body pt-9 pb-0">
                <div class="row mb-12">
                    <div class="col-lg-6">
                        <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
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
                            <div class="text-end mb-5">
                                <a class="btn btn-sm btn-light-info" id="bulk_barcode" target="_new">Toplu Barkod
                                    Yazdır</a>
                            </div>
                            <table id="kt_datatable_example_5" class="table table-striped gy-5 gs-7 rounded">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>
                                            <i class="bi bi-columns-gap"></i>
                                        </th>
                                        {{-- <th>Sıra</th> --}}
                                        <th>TDID</th>
                                        <th>Ürün Kodu</th>
                                        <th>Ürün Adı</th>
                                        <th>İade Sebebi</th>
                                        <th>Arıza Notu</th>
                                        <th>Revizyon</th>
                                        <th class="text-center">
                                            <i class="bi bi-upc-scan fs-3 text-dark"></i>
                                        </th>
                                        <th class="text-center">
                                            <i class="bi bi-camera fs-3 text-dark"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($return->details as $item)
                                        <tr @if ($item->isOk == 2) style="color: green;text-decoration: line-through;" @else class="talep_onay" @endif
                                            id="talep_{{ $item->id }}" data-id="{{ $item->id }}">
                                            <td>
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input onclick="urunOnay({{ $item->id }})" type="checkbox"
                                                        class="form-check-input choosen" value="{{ $item->id }}"
                                                        @if ($item->isOk == 0) checked="" @endif>
                                                </div>
                                            </td>
                                            {{-- <td>{{ $say }}</td> --}}
                                            <td>
                                                <small class="text-primary">{{ $item->id }}</small>
                                            </td>
                                            <td><small
                                                    class="productcode_{{ $item->id }}">{{ $item->product_code }}</small>
                                            </td>
                                            <td><small
                                                    class="productname_{{ $item->id }}">{{ $item->product_name }}</small>
                                            </td>
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
                                                <a href="#" onclick="action('{{ $item->id }}')"
                                                    class="btn btn-sm btn-light-info fw-bold fs-8 py-1 px-3">
                                                    {{ $item->revizyon_product_id ? $item->revizyon_product_id . ' - ' . getProduct($item->revizyon_product_id) : 'Revizyon' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-light-primary border border-primary py-1"
                                                    type="button"
                                                    href="{{ route('returns.product_acceptance.barcode', $item->id) }}"
                                                    target="_new">
                                                    <i class="bi bi-upc pe-0 fs-3"></i>
                                                </a>
                                            </td>
                                            <td class="buttons-{{ $item->id }}">
                                                <a class="btn btn-sm btn-light-primary border border-primary py-1 take-photo {{ empty($item->captured_image) ? '' : 'd-none' }}"
                                                    data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#modal_image_capture">
                                                    <i class="bi bi-camera-fill pe-0 fs-3"></i>
                                                </a>
                                                <a href="{{ asset('captures/' . $item->captured_image) }}"
                                                    data-caption="{{ $item->product_note }}"
                                                    class="btn btn-sm btn-light-primary border border-primary py-1 captured-image {{ empty($item->captured_image) ? 'd-none' : '' }}">
                                                    <i class="bi bi-image-fill pe-0 fs-3"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        {{-- @php $say++; @endphp --}}
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
            <div class="card-footer"></div>
        </div>
    </div>
    <!--end::Container-->
@endsection

@section('extra_content')
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
                        action="{{ route('returns.product_acceptance.approve') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">Kontrol Onayı</h1>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <textarea class="form-control form-control-solid" rows="4" name="note_onay" placeholder="Onay Notu"></textarea>
                        </div>
                        <div class="mb-13">
                            <div class="text-muted fw-semibold fs-6">
                                İncelenen talepteki ürünler belirtiğiniz revizyon kodlarıyla birlikte IOM Atölyeye sevk
                                edilecektir. Onaylıyor musunuz? <br>
                                Devam etmeden ürünleri ve kodlarını lütfen kontrol ediniz. <br>
                                Uygunsuzluk veya talep ile ilgili notunuz varsa giriniz.
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
                                <small class="ms-1 text-muted" id="sonuc">
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
    <div class="modal fade" id="modal_image_capture" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                    <form id="image_capture_form">
                        <div class="row my-auto">
                            <div class="col-6">
                                <div id="image_capture_area" style="width: 350px; height: 350px" class="border rounded"></div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-center bg-light border rounded" id="results">
                                    Önizleme
                                </div>
                            </div>
                            <div class="mb-13 text-center">
                                <input type=button class="btn btn-light-primary border border-primary py-1 mt-3"
                                    value="Fotoğraf Çek" onClick="take_snapshot()">
                            </div>
                            <div class="d-flex flex-column mb-8">
                                <textarea class="form-control form-control-solid" rows="4" name="product_note" placeholder="Ürün Notu"></textarea>
                            </div>
                            <div class="text-center">
                                <input type="hidden" name="image" class="image-tag">
                                <input type="hidden" name="detail_id" id="detail_id">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                                <button type="button" id="modal_image_capture_submit" class="btn btn-primary">
                                    <span class="indicator-label">Onayla</span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <!--end::Vendors Javascript-->
    <script>
        function urunOnay(id) {
            $.ajax({
                type: "get",
                url: "{{ route('urunOnayMK') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    $(".result").html(response);
                    var durum = document.getElementById('talep_' + id).className;

                    if (durum == 'talep_gelmedi') {
                        document.getElementById('talep_' + id).className = 'talep_onay';
                    }

                    if (durum == 'talep_onay') {
                        document.getElementById('talep_' + id).className = 'talep_gelmedi';
                    }
                }
            });
        }

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

        $('#bulk_barcode').on('click', function() {
            var choosen = [];
            $(".choosen").each(function() {
                if ($(this).is(":checked")) {
                    choosen.push($(this).val());
                }
            });
            choosen = choosen.toString();
            $.ajax({
                type: "POST",
                url: "{{ route('returns.product_acceptance.bulk_barcode') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    choosen: choosen
                },
                success: function(data) {
                    w = window.open(window.location.href, "_blank");
                    w.document.open();
                    w.document.write(data);
                    w.document.close();
                    w.window.print();
                }
            });
        });
    </script>
    <script>
        function startWebcam() {
            Webcam.set({
                width: 350,
                height: 350,
                image_format: 'jpeg',
                jpeg_quality: 100,
                flip_horiz: true
            });

            Webcam.attach('#image_capture_area');
        }

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                $('#results').css('height', '350px');
                $('#results').css('padding', '10px');
            });
        }

        $('.take-photo').on('click', function() {
            var data = $(this).attr('data-id');
            $('#detail_id').val(data);
            startWebcam();
        });

        $(document).on('click', '#modal_image_capture_submit', function() {
            let catpureImageModal = $('#modal_image_capture');
            let saveImage = $('#image_capture_form').serializeArray();
            let button = $(this);
            let detail_id = $('#detail_id').val();
            button.attr("data-kt-indicator", "on");
            $.ajax({
                type: "POST",
                url: "{{ route('returns.product_acceptance.image_capture') }}",
                data: {
                    saveImage: saveImage,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response['message'] == 'success') {
                        $('#image_capture_form').trigger("reset");
                        $('#results').html("");
                        button.removeAttr('data-kt-indicator');
                        catpureImageModal.modal('hide');
                        $(`td.buttons-${detail_id} .take-photo`).addClass('d-none');
                        let captureButton = $(`td.buttons-${detail_id} .captured-image`);
                        captureButton.removeClass('d-none');
                        captureButton.attr('href');
                        captureButton.attr('href', captureButton.attr('href') + '/' + response['image_name']);
                        Webcam.reset();
                    }
                }
            });
        });

        $('#modal_image_capture').on('hidden.bs.modal', function() {
            Webcam.reset();
        })
    </script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $('.captured-image').fancybox();
    </script>
@endsection
