@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl px-2" id="kt_content_container">
        <div class="row mb-8">
            <div class="col-6">
                <div class="card h-150px">
                    <div class="position-absolute top-50 end-0 translate-middle-y opacity-10 pe-none text-end">
                        <img src="{{ asset('assets/media/icons/duotune/ecommerce/ecm006.svg') }}" class="w-125px">
                    </div>
                    <div class="card-body d-flex flex-column justify-content-around">
                        <strong class="d-block text-info fs-2x">{{ $vehicle->plate_number }}</strong>
                        <span class="d-block fs-4">{{ $vehicle->name }}</span>
                        <strong class="d-block fs-3">{{ mb_strtoupper($driver->name) . ' ' . mb_strtoupper($driver->surname) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-150px">
                    <div class="position-absolute top-50 end-0 translate-middle-y opacity-10 pe-none text-end">
                        <img src="{{ asset('assets/media/icons/duotune/maps/map008.svg') }}" class="w-125px">
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <span class="fw-bold text-center text-gray-700" style="font-size: 3rem">
                            {{ $deliveryCounts }} <br> Nokta
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($plannedDeliveries as $item => $value)
            <span class="d-inline-block position-relative ms-2 mb-4 mt-8">
                <span class="d-inline-block mb-2 fs-2 fw-bold">
                    <i class="far fa-calendar-alt fs-1"></i> {{$item}}
                </span>
                <span class="d-inline-block position-absolute h-5px bottom-0 end-0 start-0 bg-primary translate rounded"></span>
            </span>
            @foreach (json_decode(json_encode($value)) as $item)
                <!--begin::Card-->
                <div role="button" class="card mb-2 view-transport-detail bg-hover-light border" 
                    data-link="{{ route('bicozumExpress.transportDetail', ['transport_code' => $item->transport_code]) }}">
                    <!--begin::Card body-->
                    <div class="card-body position-relative pt-0 px-3">
                        <span class="position-absolute top-0 start-0">
                            <span class="badge badge-light text-info m-2">
                                {{ $item->id }}
                            </span>
                        </span>
                        <div class="d-flex flex-stack position-relative mt-6">
                            <!--begin::Bar-->
                            @switch($item->delivery_type)
                                @case(0)
                                    <div class="position-absolute h-100 top-0 start-0 d-flex align-items-center">
                                        <span class="me-2 text-primary fw-bold fs-3">TA</span>
                                        <div class="h-50px w-4px bg-primary rounded"></div> 
                                    </div>
                                    @break
                                @case(1)
                                    <div class="position-absolute h-100 top-0 start-0 d-flex align-items-center">
                                        <span class="me-2 text-success fw-bold fs-3">TE</span>
                                        <div class="h-50px w-4px bg-success rounded"></div> 
                                    </div>
                                    @break
                            @endswitch
                            <!--end::Bar-->
        
                            <!--begin::Info-->
                            <div class="d-flex ms-12 min-w-125px">
                                <div class="fs-7 me-12">
                                    <small class="text-gray-400 fw-bold d-block"><strong>{{ $item->type }}</strong></small>
                                    <span class="d-block">{{ $item->to_name }}</span>
                                    <span class="d-block text-gray-700">{{ $item->to_phone }}</span>
                                    <span class="fs-7 text-darl fw-bold">{{ $item->planned_date }}</span>
                                </div>
                            </div>
                            <!--end::Info-->
                            
                            <div class="text-end">
                                <span class="text-dark fw-bold mb-1">
                                    <small>{{ $item->to_town . '/' . mb_strtoupper($item->to_city) }}</small>
                                </span>
                                <small class="d-block text-gray-600">
                                    {{ $item->to_address }}
                                </small>
                                <div class="fs-5 text-end mb-2">
                                    <span class="badge badge-{{ $item->status_color }}">
                                        <small>{{ $item->status }}</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            @endforeach
        @endforeach
    </div>
    <!--end::Container-->
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/customers/list/list.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/apps/customers/add.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/widgets.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/modals/create-transport-request.js') }}"></script> --}}
    <!--end::Page Custom Javascript-->
    <script>
        $('.view-transport-detail').on('click', function () {
            let link = $(this).data('link');;
            $(location).attr('href',link);
        });
    </script>
@endsection