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
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Add customer-->
                {{-- <a href="{{ route('returns.create') }}" class="btn btn-primary">Talep Oluştur</a> --}}
                <!--end::Add customer-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-50px">Talep Kodu</th>
                        <th class="min-w-150px">Talep Durumu</th>
                        <th class="min-w-150px">Detaylar</th>
                        <th class="min-w-50px">Ürün Adedi</th>
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
                            <span class="text-dark">#{{ $item->id }}</span>
                        </td>
                        <td>
                            <div class="badge badge-info">{{ config('sebportal.magaza_durumlar.'.$item->status) }}</div>
                        </td>
                        <td>
                            <small>
                                <span class="text-info">Talep Tarihi : </span> <span class="text-muted">{{ $item->created_at->format('d.m.Y H:i') }}</span> <br>
                                <span class="text-primary">Son Güncelleme : </span> <span class="text-muted">{{ $item->updated_at->format('d.m.Y H:i') }}</span> <br>
                                <span class="text-dark">Müşteri : </span> <span class="text-muted">
                                    {{ $item->consumer->firstName }} {{ $item->consumer->lastName }}
                                </span>
                            </small>
                        </td>
                        <td>
                            {{ $item->adet }}
                        </td>
                        <!--begin::Action=-->
                        <td class="text-end">
                            <span class="btn btn-sm btn-light-primary btn-active-light-info coming-soon">İncele</span>
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

    <script>
        $(document).on('click', '.coming-soon', function () {
            toastr.error("Özellik Hazırlanıyor");
        });
    </script>
@endsection