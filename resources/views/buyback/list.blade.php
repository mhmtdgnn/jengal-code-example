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
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-25px">Kod</th>
                        <th class="min-w-125px">Ad</th>
                        <th class="min-w-125px">Telefon</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-125px">Tarih</th>
                        <th class="text-end min-w-70px"></th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-semibold text-gray-600">
                    <!--begin::Table row-->
                    @foreach ($buybackRequests as $item)
                        <tr>
                            <td><span class="text-info">#{{ $item->id }}</span></td>
                            <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                            <td><small class="text-muted">{{ $item->phone }}</small></td>
                            <td><small>{{ $item->email }}</small></td>
                            <td>
                                <i class="far fa-calendar"></i>
                                {{ date_format($item->created_at,"Y-m-d")}}
                                <i class="far fa-clock"></i>
                                {{ date_format($item->created_at,"H:i")}}
                                {{-- <span class="text-muted">Son Güncelleme : {{ $item->updated_at}}</span> --}}
                            </td>
                            <!--begin::Action=-->
                            <td class="text-end">
                                <a href="{{ route('buyback.detail', $item->id) }}" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Detay</a>
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

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <!--end::Vendors Javascript-->
@endsection
