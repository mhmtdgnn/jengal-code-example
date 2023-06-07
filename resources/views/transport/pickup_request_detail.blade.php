@extends('common.layout')

@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <!--begin::Title-->
            <div class="d-flex justify-content-between align-items-center w-100 flex-wrap py-8">
                <!--begin::store-->
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-info p-3 me-2">{{ $pickUpRequest->id }}</span>
                        <span class="text-gray-700 fs-2 fw-bold me-1">Talep Bilgileri</span>
                    </div>
                </div>
                <!--end::store-->
                <div>
                    @if ($pickUpRequest->status == 1000 || $pickUpRequest->status == 1036)
                        @can('bicozumExpress.pickupRequestCancel')
                            <button type="button" class="btn btn-danger" data-id="{{ $pickUpRequest->id }}" id="pickup_equest_cancel_button">İptal</button>
                        @endcan
                        @can('bicozumExpress.pickupRequestApprove')
                            <button type="button" class="btn btn-primary" data-id="{{ $pickUpRequest->id }}" id="pickup_equest_approve_button">Onayla</button>
                        @endcan
                    @endif
                    @if ($pickUpRequest->status == 1035)
                        @can('bicozumExpress.pickupRequestRepairComplete')
                            <button type="button" class="btn btn-primary" data-id="{{ $pickUpRequest->id }}" id="pickup_equest_repair_complete_button">Tamir Tamamlandı</button>
                        @endcan
                    @endif
                </div>
            </div>
            <!--end::Title-->
        </div>
        <span class="badge badge-{{ $pickUpRequest->statusInfo->status_color }} rounded-0 fs-7 p-1">
            {{ mb_strtoupper($pickUpRequest->statusInfo->status_name) }}
        </span>
        <div class="card-body pt-9 pb-0">
            <div class="row mb-12">
                <div class="col-lg-3">
                    <div class="h-100 p-5 pb-8">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5 pe-8">
                                Müşteri Bilgileri
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 gy-2">
                                <tbody class="text-dark">
                                    <tr>
                                        <td>
                                            <i class="fas fa-user text-dark me-3"></i> 
                                            {{ $pickUpRequest->consumer->firstName.' '.$pickUpRequest->consumer->lastName }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-phone text-dark me-3"></i>
                                            <strong>{{ $pickUpRequest->consumer->phone }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::Underline-->
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="position-relative h-100 p-5 text-gray-700">
                         <!--begin::Underline-->
                         <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block text-dark mb-1 fs-5 pe-8">
                                Sipaiş Notu
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <p>
                            {{ $pickUpRequest->note }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="border border-2 h-100 rounded p-5">
                                <table class="table table-row-dashed table-row-gray-300 gy-2">
                                    <tbody class="text-gray-600">
                                        <tr>
                                            <td>
                                                <i class="fas fa-truck-pickup me-3"></i>
                                                <small>Sipariş Tipi</small>
                                            </td>
                                            <td>
                                                {{ $pickUpRequest->service->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fas fa-wallet me-3"></i>
                                                <small>Ödeyen</small>
                                            </td>
                                            <td>
                                                @switch($pickUpRequest->whopays)
                                                    @case('firma_oder')
                                                        Firma Öder
                                                        @break
                                                    @case('musteri_oder')
                                                        Müşteri Öder
                                                        @break
                                                    @default
                                                    
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fab fa-cc-mastercard me-3"></i>
                                                <small>Ödeme Yöntemi</small>
                                            </td>
                                            <td>
                                                @switch($pickUpRequest->paying_type)
                                                    @case('nakit')
                                                        Nakit
                                                        @break
                                                    @case('kredikarti')
                                                        Kredi Kartı
                                                        @break
                                                    @default
                                                        
                                                @endswitch
                                                {{-- {{ ($pickUpRequest->paying_type == 'nakit') ? 'Nakit' : 'Kredi Kartı' }} --}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="position-relative bg-light border text-gray-600 p-3 rounded mb-3">
                                <div class="position-absolute top-0 end-0">
                                    <i class="fas fa-headset fs-3 m-2"></i>
                                </div>
                                <strong class="d-inline-block mb-1 fs-7 text-info">
                                    Talebi Açan
                                </strong>
                                <small class="d-block">{{ $pickUpRequest->user->name }}</small>
                                <small class="d-block">{{ $pickUpRequest->user->gsm }}</small>
                                <small class="d-block">{{ $pickUpRequest->user->email }}</small>
                                <small class="d-block align-items-center fw-bold mt-1">
                                    Tarih/Saat :{{ $pickUpRequest->created_at->format('d-m-Y H:i') }}
                                </small>
                            </div>
                            @if($pickUpRequest->spare_product == 1)
                                <div class="alert alert-success bg-light-success d-flex align-items-center px-4 py-2 mb-0">
                                    <i class="fas fa-box-open fs-2x me-3"></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mt-3 mb-1 text-dark">YEDEK ÜRÜN VAR</h4>
                                        <small>Yedek ürün hizmeti verilecek.</small>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-secondary bg-light-secondary d-flex align-items-center px-4 py-2 mb-0">
                                    <i class="fas fa-box-open fs-2x me-3"></i>
                                    <div class="d-flex flex-column text-center">
                                        <h4 class="mt-3 mb-1 text-gray-600">YEDEK ÜRÜN YOK</h4>
                                        <small>Yedek ürün hizmeti yok.</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                <li class="nav-item">
                    <a class="nav-link text-primary active" data-bs-toggle="tab" href="#kt_tab_pane_1">
                        Sipariş Bilgileri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" data-bs-toggle="tab" href="#kt_tab_pane_2">
                        Sipariş LOG
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" data-bs-toggle="tab" href="#kt_tab_pane_3">
                        Taşıma Bilgileri
                    </a>
                </li>
            </ul>
            
            <div class="tab-content mb-12" id="myTabContent">
                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="border border-2 h-100 rounded">
                                <table id="kt_datatable_example_5" class="table  table-striped bg-white gy-5 gs-7 rounded">
                                    <thead>
                                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                            <th><small>Ürün</small></th>
                                            <th><small>Açıklama</small></th>
                                            <th class="w-25px"><small>Garanti</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pickUpRequest->details as $item)
                                            <tr>
                                                <td>
                                                    <span class="text-info">{{ $item->product->product_code ?? '' }}</span>
                                                    {{ $item->product->product_name ?? '' }}
                                                </td>
                                                <td>{{ $item->description }}</td>
                                                <td class="text-center">
                                                    @if ($item->has_warranty == 1)
                                                        <i class="fas fa-check fs-2x text-success"></i>
                                                    @else
                                                        <i class="fas fa-times fs-2x text-danger"></i>        
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border border-2 h-100 rounded p-5">
                                <strong class="d-block text-primary mb-3">
                                    <i class="fas fa-map-marker-alt fs-2x me-3"></i> 
                                    {{ mb_strtoupper($pickUpRequest->address_name) }}
                                </strong>
                                <span class="d-block mb-2">{{ $pickUpRequest->address }}</span>
                                <strong class="d-block">{{ $pickUpRequest->town }} / {{ mb_strtoupper($pickUpRequest->city) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-row-bordered gy-4">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th class="w-50px">Key</th>
                                    <th>Açıklama</th>
                                    <th class="w-100px">Kullanıcı</th>
                                    <th class="w-125px">Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $item)
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info">{{ $item->type_key }}</span>
                                        </td>
                                        <td>{{ $item->text }}</td>
                                        <td>
                                            <span class="badge badge-light-primary">
                                                <small>{{ $item->user->name }}</small>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ date_format($item->created_at, 'Y-m-d H:i') }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                    @foreach ($relatedTransportRequest as $item)
                    <div class="d-flex align-items-center justify-content-center">
                        <span class="bullet bullet-vertical h-150px bg-{{ ($item->delivery_type == 0) ? 'primary' : 'success'}}"></span>
                        <div class="row w-100">
                            @if ($item->delivery_type == 0)
                                <div class="separator separator-dashed separator-content border-primary mt-4"></div>
                            @else
                                <div class="separator separator-dashed separator-content border-success mt-4"></div>
                            @endif
                            <div class="col-lg-6">
                                <div class="table-responsive bg-white position-relative h-100 p-5">
                                    <div class="position-absolute top-0 end-0 opacity-10 pe-none text-end">
                                        <img src="{{ asset('/assets/media/icons/duotune/ecommerce/ecm006.svg') }}" class="w-125px">
                                    </div>
                                    <table class="table gy-0 mt-3 text-gray-600 fs-7">
                                        <thead>
                                            <tr>
                                                <th class="w-150px fw-bold">
                                                    <i class="fas fa-ellipsis-v text-info"></i> Talep No
                                                </th>
                                                <th class="fw-bold">{{ $item->transport_code }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><i class="fas fa-ellipsis-v text-info"></i> Referans No</td>
                                                <td>{{ $item->reference_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-ellipsis-v text-info"></i> Talep Tipi</td>
                                                <td>{{ $item->transport_type }}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-ellipsis-v text-info"></i> Kapıda Ödeme</td>
                                                <td>{{ ($item->payment_at_door == 1) ? 'Evet' : 'Hayır' }}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-ellipsis-v text-info"></i> Teslimat Yönü</td>
                                                <td>
                                                    <span class="d-flex align-items-center text-{{ ($item->delivery_type == 1) ? 'success' : 'primary' }}">
                                                        @if ($item->delivery_type)
                                                            <i class="fas fa-angle-double-right fs-4 me-1 text-success"></i>
                                                        @else
                                                            <i class="fas fa-angle-double-left fs-4 me-1 text-primary"></i>
                                                        @endif
                                                        <strong>{{ ($item->delivery_type == 1) ? 'Teslim Et' : 'Teslim Al' }}</strong>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="separator my-4"></div>
                                    <div class="fs-8">
                                        <span>{{ $item->to_name }}</span> - 
                                        <strong>{{ $item->to_phone }}</strong>
                                        <p class="mb-1">{{ $item->to_address }} <strong>{{ $item->town . '/' . mb_strtoupper($item->city) }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative bg-white h-100 p-4">
                                    {{-- <div class="position-absolute top-0 end-0 opacity-10 pe-none text-end">
                                        <img src="{{ asset('/assets/media/icons/duotune/text/txt004.svg') }}" class="w-125px">
                                    </div> --}}
                                    <div class="table-responsive">
                                        <table class="table table-hover table-rounded table-striped gy-2 gs-4">
                                            <tbody>
                                                @foreach ($item->logs as $item)
                                                    <tr>
                                                        {{-- <td class="w-75px"><span class="badge badge-light-primary">{{ $item->type_key }}</span></td> --}}
                                                        <td><small class="text-gray-600">{{ $item->description }}</small></td>
                                                        <td class="w-75px text-center"><span class="badge badge-light-info">{{ $item->user->name ?? '' }}</span></td>
                                                        <td class="w-125px text-end">
                                                            <small>{{ date_format($item->created_at, 'Y-m-d') }}</small>
                                                            <small class="text-gray-600">{{ date_format($item->created_at, 'H:i') }}</small>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!--end::Container-->
@endsection

@section('footer_scripts')
    <script>
        $(document).on('click', '#pickup_equest_approve_button', function () {
            let pickup_request_id = $(this).data('id');

            const { value: date } = Swal.fire({
                title: 'Randevu tarihi seçin',
                input: 'select',
                inputOptions: {!! $datePeriod !!},
                inputPlaceholder: 'Randevu Tarihi Seçiniz',
                confirmButtonText: 'Kaydet',
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            approveRequest(value, pickup_request_id);
                        } else {
                            resolve('Tarih seçmelisiniz')
                        }
                    })
                }
            });
        });

        function approveRequest(date, id) {
            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.pickupRequestApprove') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    date: date,
                    pickup_request_id: id 
                },
                success: function (response, text, xhr) {
                    console.log(response);
                    if (xhr.status == 200) {
                        Swal.fire('Başarılı!', 'Taşıma talebi eklendi.','success').then(function(){
                            location.reload();
                        });
                    } else {
                        Swal.fire('Hata!', 'İşlem esnasında bir sorun oluştu.', 'error')
                    }
                },
                error: function(error) {
                    console.log(error);
                    Swal.fire('Hata!', 'İşlem esnasında bir sorun oluştu.', 'error')
                }
             });
        }
        
        $(document).on('click', '#pickup_equest_cancel_button', function () {

            let requestID = $(this).data('id');

            Swal.fire({
                title: 'İPTAL',
                text: "Talep iptal edilecektir onaylıyor musunuz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Hayır',
                confirmButtonText: 'Evet, iptal et!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.pickupRequestCancel') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: requestID
                        },
                        success: function (response) {
                            console.log(response);
                            if (response) {
                                Swal.fire('Başarılı!', 'Talep iptal edildi.','success').then(function(){
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Hata!', 'İşlem esnasında bir sorun oluştu.', 'error');
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            Swal.fire('Hata!', 'İşlem esnasında bir sorun oluştu.', 'error')
                        }
                    });
                }
            });
        });

        $(document).on('click', '#pickup_equest_repair_complete_button', function () {
            let requestID = $(this).data('id');

            Swal.fire({
                title: 'TAMİR TAMAMLANDI',
                text: "Talep tamir tamamlandı olarak işaretlenecek onaylıyor musunuz?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Hayır',
                confirmButtonText: 'Evet!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.pickupRequestRepairComplete') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: requestID
                        },
                        success: function (response) {
                            console.log(response);
                            if (response) {
                                Swal.fire('Başarılı!', 'Tamir tamamlandı.','success').then(function(){
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Hata!', 'İşlem esnasında bir sorun oluştu.', 'error');
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            Swal.fire('Hata!', 'İşlem esnasında bir sorun oluştu.', 'error')
                        }
                    });
                }
            });
        });
    </script>
@endsection