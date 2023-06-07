@extends('common.layout')

@section('header')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
    <!--begin::Container-->
    <div class="container-xxl px-0 px-md-5" id="kt_content_container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body positon-relative">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="d-inline-block position-relative text-center">
                                <span class="d-inline-block mb-2 text-gray-700 fs-2 fw-bold">
                                    {{ mb_strtoupper($data->type_name) }}
                                </span>
                                <span class="d-inline-block position-absolute h-5px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                            </span>
                            <span class="d-flex align-items-center">
                                @switch($data->delivery_type)
                                    @case(0)
                                        <i class="fas fa-angle-double-down fs-1 text-primary me-2"></i> <strong class="text-gray-600 fs-3">TESLİM AL</strong>
                                        @break
                                    @case(1)
                                        <i class="fas fa-angle-double-up fs-1 text-success me-2"></i> <strong class="text-gray-600 fs-3">TESLİM ET</strong>
                                        @break
                                @endswitch
                            </span>
                        </div>
                        <div class="mb-12 d-flex justify-content-between align-items-center">
                            <span class="badge badge-{{$data->status_color}}">
                                {{$data->status}}
                            </span>
                            <span class="d-inline-flex flex-column align-items-end">
                                <small>Randevu Tarihi</small>
                                <span class="fs-3 text-info">
                                    {{ $data->planned_date }}
                                </span>
                            </span>
                        </div>
                        <div class="mb-4">
                            <div class="bg-light border border-dashed rounded d-flex align-items-start p-5 pt-12 mb-5 position-relative">
                                <small class="text-info fw-bold border bg-white position-absolute top-0 end-0 px-3 py-1 rounded m-1">
                                    Teslimat Bilgileri
                                </small>
                                <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                                    <img width="40" src="{{ asset('assets/media/icons/duotune/maps/map001.svg') }}"/>
                                </span>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-dark">{{ $data->to_city . '/' . $data->to_town }}</h4>
                                    <span class="d-block">{{ $data->to_address }}</span>
                                    <strong class="mt-3 text-info">{{ $data->to_name }}</strong>
                                    <strong class="mt-3 text-info">{{ $data->to_phone }}</strong>
                                    <span class="d-block">{{ $data->to_email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 d-flex">
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
            </div>
        </div>
        <div class="row mt-10 p-5">
            <div class="col-lg-12">
                <ul class="nav nav-tabs nav-line-tabs px-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Logs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Resimler</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                        <div class="card shadow-none">
                            <div class="card-body">
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
                                                    <td>{{ $item->description }}</td>
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
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        <div class="card shadow-none">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($files as $item)
                                        <div class="col-lg-3">
                                            <!--begin::Overlay-->
                                            <a class="d-block overlay" data-fslightbox="lightbox-basic" href="https://portalcdn.bicozum.com/biportal/{{$item->file_url}}">
                                                <!--begin::Image-->
                                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                    style="background-image:url('https://portalcdn.bicozum.com/biportal/{{$item->file_url}}')">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Action-->
                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                                    <i class="bi bi-eye-fill text-white fs-3x"></i>
                                                </div>
                                                <!--end::Action-->
                                            </a>
                                            <!--end::Overlay-->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}" crossorigin="anonymous"></script>
    <script>
        fsLightbox.props.type = "image";
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script> --}}
@endsection
