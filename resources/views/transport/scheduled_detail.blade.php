@extends('common.layout')

@section('header')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
    <!--begin::Container-->
    <div class="container-xxl px-0 px-md-5" id="kt_content_container">
        <div class="d-flex flex-column gap-7 gap-lg-10 col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="me-3 ">
                        <span class="d-inline-block position-relative text-center">
                            <span class="d-inline-block mb-2 text-gray-700 fs-2x fw-bold">
                                {{ mb_strtoupper($data->type_name) }}
                            </span>
                            <span class="d-inline-block position-absolute h-5px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                    </div>
                    <span class="d-inline-flex flex-column">
                        <small>Randevu Tarihi</small>
                        <span class="fs-2x text-info">
                            {{ $data->planned_date }}
                        </span>
                    </span>
                </div>
            </div>
            <div class="text-center fs-1">
                @switch($data->delivery_type)
                    @case(0)
                        <i class="fas fa-angle-double-down fs-1 text-primary"></i> TESLİM AL
                        @break
                    @case(1)
                        <i class="fas fa-angle-double-up fs-1 text-success"></i> TESLİM ET
                        @break
                @endswitch
            </div>
            <!--begin::Order details-->
            @switch($data->type_id)
                @case(1)
                    @include('transport.partials.courier.general_detail')
                    @break
                @case(2)
                    @include('transport.partials.courier.service_detail')
                    @break
                @case(3)
                    @include('transport.partials.courier.vip_delivery_detail')
                    @break
                @default
            @endswitch
            @if (!empty($data->operation_note))
            <div class="bg-light-info border border-dashed border-info rounded d-flex align-items-start p-5">
                <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                    <img width="40" src="{{ asset('assets/media/icons/duotune/communication/com012.svg') }}"/>
                </span>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-info">Operasyon Notu</h4>
                    <p class="text-gray-900 mt-3">
                        {{ $data->operation_note }}
                    </p>
                </div>
            </div>
            @endif
            <!--end::Order details-->
            <div class="card card-flush rounded p-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Teslimat Bilgileri</h2>
                    </div>
                </div>
                {{-- <div class="bg-light border border-dashed rounded opacity-25 d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-info me-3">
                        <img width="40" src="{{ asset('assets/media/icons/duotune/maps/map008.svg') }}"/>
                    </span>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">{{ $data->from_city . '/' . $data->from_town }}</h4>
                        <span class="d-block">{{ $data->from_address }}</span>
                        <span class="d-block">{{ $data->from_name }}</span>
                        <span class="d-block">{{ $data->from_phone }}</span>
                    </div>
                </div> --}}
                <div class="bg-light border border-dashed rounded d-flex align-items-start p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                        <img width="40" src="{{ asset('assets/media/icons/duotune/maps/map001.svg') }}"/>
                    </span>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">{{ $data->to_city . '/' . $data->to_town }}</h4>
                        <span class="d-block">{{ $data->to_address }}</span>
                        <span class="mt-3">
                            <strong class="me-3">{{ $data->to_name }}</strong>
                            <strong class="me-3">{{ $data->to_phone }}</strong>
                        </span>
                        <span class="d-block">{{ $data->to_email }}</span>
                    </div>
                </div>
                <div class="my-2 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary rounded-1 me-3">
                        <i class="fas fa-sms fs-4"></i> SMS
                    </button>
                    <a href="tel:{{$data->to_phone}}" class="btn btn-secondary rounded-1 me-3">
                        <i class="fas fa-phone-alt fs-4"></i> TELEFON
                    </a>
                    <a href="https://maps.google.com/?q={{$data->to_address . $data->to_city . '/' . $data->to_town}}"
                        type="button" 
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-icon btn-secondary rounded-1 me-3">
                        <i class="fas fa-map-marker-alt fs-1 text-primary"></i>
                    </a>
                    <button type="button" class="btn btn-icon btn-secondary rounded-1 me-3">
                        <i class="fas fa-map-marker-alt fs-1 text-warning"></i>
                    </button>
                </div>
            </div>
            <div class="card text-center">
                <!--begin::Body-->
                <div class="card-body py-8">
                    @switch($data->status_code)
                        @case(2010)    
                            <button type="button" 
                                id="start_delivery"
                                data-delivery-id="{{ $data->delivery_id }}"
                                class="btn btn-primary w-100 mb-4 border border-dark">
                                <i class="fas fa-chess-board fs-1"></i> BAŞLAT
                            </button>
                        @break
                        @case(2020)
                            <div class="py-4">
                                <button type="button"
                                    id="print-receipt"
                                    class="btn btn-secondary w-100 mb-4 border border-dark">
                                    <i class="fas fa-print fs-1"></i>FORM YAZDIR
                                </button>
                                <div id="preview_images" class="bg-light border border-dashed border-dark rounded mb-4 p-5">
                                    <div class="row">
                                        <span id="preview_image_text" class="d-block text-cener">Henüz resim eklenmemiş</span>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form mb-4" method="post" enctype="multipart/form-data">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Dropzone-->
                                        <div class="dropzone" id="transport_photo_upload">
                                            <!--begin::Message-->
                                            <div class="dz-message needsclick">
                                                <!--begin::Icon-->
                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">FOTOĞRAF EKLE</h3>
                                                    <span class="fs-7 fw-semibold text-gray-400">En fazla 5 adet fotoğraf ekleyebilirsiniz.</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div>
                                        <!--end::Dropzone-->
                                    </div>
                                    <!--end::Input group-->
                                </form>
                                <!--end::Form-->
                                <button type="button" id="delivery-fail" class="btn btn-warning text-dark w-100 mb-4 border border-dark">
                                    <i class="fas fa-exclamation-triangle text-dark fs-1"></i> SORUN BİLDİR
                                </button>
                                <button type="button" id="delivery-complete" class="btn btn-success w-100 mb-4 border border-dark">
                                    <i class="fas fa-check-double fs-1"></i>TAMAMLANDI
                                </button>
                            </div>
                        @break
                        @case(2030)
                            <div class="alert alert-warning d-flex align-items-center p-5">
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-3">
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"/>
                                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </span>
                                <div class="d-flex justify-content-center flex-column w-100">
                                    <h4 class="mb-1 text-warning">PROBLEM BİLDİR</h4>
                                    <span>Teslimat operasyon tarafından yeniden planlanacaktır.</span>
                                </div>
                            </div>
                        @break
                        @case(2040)
                            <button type="button"
                                id="print-receipt"
                                class="btn btn-secondary w-100 mb-4 border border-dark">
                                <i class="fas fa-print fs-1"></i>FORM YAZDIR
                            </button>
                            <div id="preview_images" class="bg-light border border-dashed border-dark rounded mb-4 p-5">
                                <div class="row">
                                    <span id="preview_image_text" class="d-block text-cener">Henüz resim eklenmemiş</span>
                                </div>
                            </div>
                            <div class="alert alert-success bg-light-success d-flex align-items-center p-5">
                                <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                        <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </span>
                                <div class="d-flex justify-content-center flex-column w-100">
                                    <h4 class="mb-1 text-success">BİTİR</h4>
                                    <span>Kayıt üzerinde düzenleme yapılamaz.</span>
                                </div>
                            </div>
                        @break
                    @endswitch
                </div>
                <!--end::Body-->
            </div>
        </div>

    </div>
    <!--end::Container-->
@endsection

@section('extra_content')
<div class="d-none">
    <img id="bicozumLogo" src="{{ asset('assets/media/logos/bicozum-logo.png') }}" width="300">
</div>
<div class="d-none" id="image_view_template">
    <div class="h-100px w-100px bg-white m-3 p-0 rounded border overflow-hidden mb-4 image-item">
        <a class="d-block overlay" href="#">
            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded w-100px h-100px">
            </div>
            <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                <i class="bi bi-eye-fill text-white fs-3x"></i>
            </div>
        </a>
    </div>
</div>
@php
    $products = [];
    switch ($data->type_id) {
        case 1:
            foreach ($packages as $item) {
                $products[] = ['name' => $item->product->product_code . '-' . $item->product->product_name];
            }
            break;
        case 2:
            foreach ($service->details as $item) {
                $products[] = [
                    'name' => $item->product_code . '-' . $item->product_name,
                    'warranty' => ($item->has_warranty == 1) ? 'Garanti Var' : 'Garanti Yok',
                    'description' => str_replace(["\r", "\n", "\r\n"], "", $item->description)
                ];
            }
            break;
        case 3:
            foreach ($vipDeliveryProducts as $item) {
                $pc = empty($item->prod->product_code) ? '' : $item->prod->product_code;
                $pn = empty($item->prod->product_name) ? '' : $item->prod->product_name;
                $products[] = ['name' => $pc . '-' . $pn];
            }
            break;
    }
@endphp
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
    <script>
        fsLightbox.props.type = "image";
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script> --}}
    <script>
        $("#deliveryCompleteCollapse").on("hide.bs.collapse", function(){
            $("#deliveryCompleteCollapseButton").removeClass('btn-primary');
            $("#deliveryCompleteCollapseButton").addClass('btn-light-primary');
        });
        $("#deliveryCompleteCollapse").on("show.bs.collapse", function(){
            $("#deliveryCompleteCollapseButton").addClass('btn-primary');
            $("#deliveryCompleteCollapseButton").removeClass('btn-light-primary');
        });
    </script>
    @if ($data->status_code == 2020)
        <script>
            var CSRF_TOKEN = "{{ csrf_token() }}";

            var myDropzone = new Dropzone("#transport_photo_upload", {
                url: "{{ route('bicozumExpress.transportImageUpload') }}", // Set the url for your upload script location
                paramName: "file", // The name that will be used to transfer the file
                maxFiles: 6,
                maxFilesize: 10, // MB
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                sending: function (file, xhr, formData) {
                    formData.append("_token", CSRF_TOKEN);
                    formData.append("transport_id", {{ $data->transport_id }});
                },
                success: function(file, response) 
                {
                    let imageTemplate = $('#image_view_template .image-item').clone();
                    imageTemplate.find('a').attr('href', response.success.fileURL);
                    imageTemplate.find('a').attr('data-fslightbox', 'lightbox-basic');
                    imageTemplate.find('.overlay-wrapper').css('background-image', 'url('+ response.success.fileURL +')');
                    $('#preview_images .row').append(imageTemplate);
                    $('#preview_image_text').addClass('d-none');
                    refreshFsLightbox();
                    var fileuploded = file.previewElement.querySelector("[data-dz-name]");
                    fileuploded.innerHTML = response.success.filename;
                },
                error: function(file, response)
                {
                    return false;
                },
                complete: function (file) {
                    thisDropzone = this;
                    thisDropzone.removeFile(file);
                    toastr.success("Resin yüklendi...");
                }
            });
        </script>
    @endif

    @if ($data->status_code == 2020 || $data->status_code == 2040)
        <script>
            function existingPhotos() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('bicozumExpress.getTransportFiles') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        transport_id: {{ $data->transport_id }}
                    },
                    success: function (response) {
                        if (response) {
                            console.log(response);
                        $.each(response, function (index, value) {
                                let imageTemplate = $('#image_view_template .image-item').clone();
                                imageTemplate.find('a').attr('href', value);
                                imageTemplate.find('a').attr('data-fslightbox', 'lightbox-basic');
                                imageTemplate.find('.overlay-wrapper').css('background-image', 'url('+ value +')');
                                $('#preview_images .row').append(imageTemplate);
                                $('#preview_image_text').addClass('d-none');
                                refreshFsLightbox();
                        });
                        }
                    }
                });
            }
            existingPhotos();
        </script>
    @endif
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        //Göreve Başla
        $('#start_delivery').on('click', function () {
            let deliveryID = $(this).data('delivery-id');
            let transportRequestID = {{ $data->transport_id }}

            Swal.fire({
                title: 'Teslimata Başla!',
                text: "Müşteriye yola çıktığınızı bildiren SMS gönerilecek.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#50cd89',
                cancelButtonColor: '#d33',
                cancelButtonText: 'İptal',
                confirmButtonText: 'Evet Başla!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.courierStartDelivery') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            delivery_id : deliveryID,
                            transport_request_id: transportRequestID
                        },
                        success: function (response, textStatus, xhr) {
                            console.log(response);
                            if (xhr.status == 200) {
                                toastr.success("Teslimat görevi başladı!");
                                location.reload();
                            } else {
                                toastr.error("Bir sorun oluştu!");
                            }
                        }
                    });
                }
            })
        });
        // Teslimat Formu Yazdır 
        $('#print-receipt').on('click', function () {
            var imgToExport = document.getElementById('bicozumLogo');
            var canvas = document.createElement('canvas');
                    canvas.width = imgToExport.width; 
                    canvas.height = imgToExport.height; 
                    canvas.getContext('2d').drawImage(imgToExport, 0, 0);
            let base64Image = canvas.toDataURL('image/png');

            let currentDate = '{{ date("d.m.Y") }}'
            let consumerName = '{{ $data->to_name }}';
            let consumerPhone = '{{ $data->to_phone }}';
            let consumerEmail = '{{ $data->to_email }}';
            let consumerAddress = `{!! $data->to_address !!}`;
            let consumerCityTown = '{{ $data->to_city . '/' . $data->to_town }}';
            let products = `{!! json_encode($products) !!}`;
            console.log(products);
            let items = JSON.parse(products).map((item) => {
                return 	{
                    stack: [
                        {
                            style: 'tableExample',
                            layout: 'headerLineOnly',
                            table: {
                                body: [
                                    [{
                                        stack: [
                                            {text: item.name, fontSize: 10, alignment: 'left', margin: [0,2,0,0]},
                                            {text: JSON.stringify(item.description), fontSize: 10, alignment: 'left', margin: [0,0,0,0], color: '#888888'},
                                            {text: item.warranty, fontSize: 10, bold: true, alignment: 'right', margin: [0,0,0,0]}
                                        ],
                                    }],
                                ]
                            },
                        },
                        {canvas: [ { type: 'line', x1: 0, y1: 0, x2: (89*2.835) - 2*(3*2.835) , y2: 0, lineWidth: 0.5 } ]},
                    ]
                };
            });

            console.log(items);

            var docDefinition = {
                pageSize: { width: 89*2.835, height: 'auto' },
                pageMargins: [ 3*2.835, 12*2.835, 3*2.835, 12*2.835 ],
                content: [
                    {
                        columns: [
                            {
                                width: 'auto',
                                image: base64Image,
                                fit: [100, 100]
                            },
                            {
                                stack: [
                                    'TESLİM FORMU',
                                ],
                                style: 'header'
                            },
                        ],
                        margin: [0,0,0,15]
                    },
                    {
                        columns: [
                            {
                                stack: [
                                { text: consumerName, fontSize: 13, alignment: 'left', margin: [0,10,0,0], bold: true},
                                // { text: '11111111111', fontSize: 10, alignment: 'left', margin: [0,0,0,7]},
                                ],
                            },
                            { text: currentDate, fontSize: 13, alignment: 'right', margin: [0,10,0,7] },
                        ],
                    },
                    {
                        columns: [
                            {
                                stack: [
                                    { text: 'TELEFON', fontSize: 10, alignment: 'left', margin: [0,10,0,0], bold: true},
                                    { text: consumerPhone, fontSize: 10, alignment: 'left', margin: [0,0,0,3]},
                                ]
                            },
                            {
                                stack: [
                                    { text: 'EMAİL', fontSize: 10, alignment: 'left', margin: [0,10,0,3], bold: true},
                                    { text: consumerEmail, fontSize: 10, alignment: 'left', margin: [0,0,0,3]},
                                ]
                            }
                        ],
                    },
                    { text: 'ADRES', fontSize: 10, alignment: 'left', margin: [0,8,0,3], bold: true},
                    { text: consumerAddress, fontSize: 10, alignment: 'left', margin: [0,0,0,0]},
                    { text: consumerCityTown, fontSize: 10, alignment: 'left', margin: [0,1,0,7], bold: true},
                    {
                        columns: [{
                            stack: [
                                { text: 'ÜRÜN DETAYLARI', fontSize: 14, alignment: 'left', margin: [0,18,0,7], bold: true},
                                {canvas: [ { type: 'line', x1: 0, y1: 0, x2: (89*2.835) - 2*(3*2.835) , y2: 0, lineWidth: 0.5 } ]},
                            ]
                        }]
                    },
                    ...items,
                    // { text: 'Laurastar - Laurastar / ütü', fontSize: 10, alignment: 'left', margin: [0,0,0,7]},
                    // { text: 'Buhar vermiyor', fontSize: 10, alignment: 'left', margin: [0,0,0,7]},
                    {
                        columns: [
                            { text: 'TESLİM ALAN', fontSize: 10, alignment: 'center', margin: [0,18,0,18], bold: true},
                            { text: 'TESLİM EDEN', fontSize: 10, alignment: 'center', margin: [0,18,0,18], bold: true},
                        ]
                    },
                    { text: 'Ürün kayıtlı değil ise garanti belgesi ibraz edilmelidir. Vermiş olduğum bu ürünün sadece nakliye amaçlı teslim edilmiş olduğunu, teslim alan personeli hiçbir konuya şahit tutmadığımı, yetkisinin sadece bu ürünleri Teknik Servis aynı tutanak ile teslim etmek olduğunu bildiğimi beyan ederim. Yukarıdabelirtilen ürün yetkili servise ulaştırılmak adına BiÇözüm tarafından teslim alınmıştır.Her türlü soru ve talebiniz için 0216 428 9090 numaralı telefonumuzdan ve internet sitemiz üzerinden bizimle iletişime geçebilirsiniz.', 
                        fontSize: 10, alignment: 'justify', margin: [0,22,0,10]},
                    {
                        stack: [
                            { qr: 'https://www.bicozum.com', foreground: 'navy', fit: '50' },
                        ],
                         alignment: 'center'
                    },
                    { text: 'www.bicozum.com', fontSize: 7, alignment: 'center', margin: [0,8,0,0]},
                ],
                styles: {
                    header: {
                        fontSize: 11,
                        bold: true,
                        alignment: 'right',
                        margin: [0, 18, 0, 0]
                    },
                    newLine: {
                        margin: [0, 5, 0, 5],
                    },
                    tableExample: {
                        margin: [0, 0, 0, 2]
                    },
                }
            };

            pdfMake.createPdf(docDefinition).open();
        });
        //Telimat Yapılamadı
        $('#delivery-fail').on('click', function () {
            Swal.fire({
                title: 'Neden seçiniz.',
                input: 'select',
                inputOptions: {
                    1: 'Evde bulunamadı',
                    2: 'Ücreti kabul etmedi',
                    3: 'Adres yanlış/eksik',
                    4: 'Arandı ulaşılamadı',
                    5: 'Ürünü kabul etmedi',
                    99: 'Diğer'
                },
                inputPlaceholder: 'Seçiniz...',
                showCancelButton: true,
                confirmButtonText: 'TAMAM',
                cancelButtonText: 'İPTAL',
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('bicozumExpress.transportDeliveryFail') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    transport_id: '{{ $data->transport_id }}',
                                    deliveryFailReason: value
                                },
                                success: function (response) {
                                    if (response.success) {
                                        toastr.success('Durum güncellendi.')
                                        location.reload();
                                    } else (
                                        toastr.error('Bir hata oldu!')
                                    );
                                }
                            });
                        } else {
                            resolve('Bir neden seçmelisiniz.')
                        }
                    });
                }
            });
        });
        //Telimat Tamamla
        $('#delivery-complete').on('click', function () {
            Swal.fire({
                input: 'textarea',
                inputLabel: 'Not (Opsiyonel)',
                inputPlaceholder: 'Not ekleyebilirsiniz.',
                showCancelButton: true,
                confirmButtonText: 'TAMAM',
                cancelButtonText: 'İPTAL',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.transportDeliveryComplete') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            transport_id: '{{ $data->transport_id }}',
                            type_id: '{{ $data->type_id }}',
                            reference_number: '{{ $data->reference_number }}',
                            deliveryNote: result.value
                        },
                        success: function (response) {
                            // console.log(response);
                            if (response.success) {
                                toastr.success('Durum güncellendi.')
                                location.reload();
                            } else {
                                toastr.error('Bir hata oldu!')
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection