@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Heading-->
                <div class="card-px text-center pt-15 pb-15">
                    <!--begin::Title-->
                    <h2 class="fs-2x fw-bold mb-0">BiPortal</h2>
                    <!--end::Title-->

                    <!--begin::Description-->
                    <p class="text-gray-400 fs-4 fw-semibold py-7">
                        Satış Sonrası Hizmetler Yönetimi
                    </p>
                    <!--end::Description-->

                    <!--begin::Action-->
                    <h1 class="text-primary fs-3x">HOŞGELDİNİZ</h1>
                    <!--end::Action-->
                </div>
                <!--end::Heading-->

                <!--begin::Illustration-->
                <div class="text-center pb-15 px-5">
                    <img src="{{ asset('assets/media/illustrations/sigma-1/3.png') }}" alt=""
                        class="mw-100 h-200px h-sm-325px" />
                </div>
                <!--end::Illustration-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
@endsection
