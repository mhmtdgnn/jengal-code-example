@extends('common.layout')
@section('content')
    <!--begin::Container-->
    <div class=" container-xxl " id="kt_content_container">
        <!-- begin::Invoice 3-->
        <div class="card">
            <!-- begin::Body-->
            <div class="card-body py-20">
                <!-- begin::Wrapper-->
                <div class="mw-lg-950px mx-auto w-100">
                    <!-- begin::Header-->
                    <div class="row mb-19">
                        <div class="col-md-8 text-start">
                            <span class="badge badge-info mb-3">#{{ $claim->id }}</span> 
                            <!--begin::Message-->
                            <div class="fw-bold fs-2">
                                <h3 class="d-flex align-items-center fw-bolder text-gray-800">
                                    {{ $claim->consumer->firstName }} {{ $claim->consumer->lastName }} 
                                    <span class="fs-6 ms-3">({{ $claim->consumer->phone }})</span> <br>
                                </h3>
                                <!--begin::Table-->
                                <div class="table-responsive w-100 border-bottom mb-9">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <thead>
                                            <tr class="border-bottom fs-6 fw-bold text-muted">
                                                <th class="pb-2"></th>
                                                <th class="min-w-70px text-end pb-2"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Thumbnail-->
                                                        <span class="symbol symbol-50px">
                                                            <span class="symbol-label"
                                                                style="background-image:url({{ asset('assets/media/icons/duotune/ecommerce/ecm008.svg') }});"></span>
                                                        </span>
                                                        <!--end::Thumbnail-->
                                                        <!--begin::Title-->
                                                        <div class="ms-5">
                                                            <div class="fw-bold">Product 1</div>
                                                            <div class="fs-7 text-muted">Delivery Date: 07/04/2023</div>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    02699005
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--begin::Message-->
                        </div>
                        <div class="col-md-4 border-start text-end">
                            <!-- begin::Print-->
                            <button type="button" class="btn btn-success mb-5" onclick="window.print();">
                                Teslim Formu Yazdır
                            </button>
                            <!-- end::Print-->
                            <div class="d-inline-block text-sm-end bg-light botder rounded py-5 px-12">
                                <!--begin::Logo-->
                                <h3 class="mb-0">
                                    {{ $claim->service->servis_adi }}
                                </h3>
                                <span class="text-info">{{ $claim->user->name }}</span> <br>
                                <!--end::Logo-->
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="pb-12">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column gap-7 gap-md-10">
                            <!--begin::Separator-->
                            <div class="separator"></div>
                            <!--begin::Separator-->

                            <!--begin::Order details-->
                            <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Order ID</span>
                                    <span class="fs-5">#14534</span>
                                </div>

                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Date</span>
                                    <span class="fs-5">07 April, 2023</span>
                                </div>

                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Invoice ID</span>
                                    <span class="fs-5">#INV-000414</span>
                                </div>

                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Shipment ID</span>
                                    <span class="fs-5">#SHP-0025410</span>
                                </div>
                            </div>
                            <!--end::Order details-->

                            <!--begin::Billing & shipping-->
                            <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Billing Address</span>
                                    <span class="fs-6">
                                        Unit 1/23 Hastings Road,<br />
                                        Melbourne 3000,<br />
                                        Victoria,<br />
                                        Australia.
                                    </span>
                                </div>

                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Shipping Address</span>
                                    <span class="fs-6">
                                        Unit 1/23 Hastings Road,<br />
                                        Melbourne 3000,<br />
                                        Victoria,<br />
                                        Australia.
                                    </span>
                                </div>
                            </div>
                            <!--end::Billing & shipping-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Body-->

                </div>
                <!-- end::Wrapper-->
            </div>
            <!-- end::Body-->
        </div>
        <!-- end::Invoice 1-->
    </div>
@endsection
