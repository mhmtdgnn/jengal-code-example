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
            <div class="card-toolbar">
                <a class="btn btn-lg btn-primary " id="create_list">Liste Oluştur</a>
            </div>
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
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_category_table .form-check-input"/>
                            </div>
                        </th>
                        <th class="min-w-50px">Talep Kodu</th>
                        <th class="min-w-150px">Mağaza</th>
                        <th class="min-w-150px">Talep Tarihi</th>
                        <th class="min-w-50px">Ürün Adedi</th>
                        <th class="min-w-50px">Hakediş Tarihi</th>
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
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input choosen" type="checkbox" value="{{$item->id}}" />
                            </div>
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>{{ @$item->store->name }}</div></td>
                        <td>{{ $item->created_at->format('d.m.Y H:i:s') }}</td>
                        <td>{{ $item->adet }}</td>
                        <td>{{ $item->hakedisDate }}</td>
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
    <!--begin::Progress Payment toolbar-->
		<div class="progress-payment-toolbar d-flex position-fixed px-5 fw-bold zindex-2 top-50 end-0 transform-90 mt-5 mt-lg-20 gap-2">
			<!--begin::Demos drawer toggle-->
			<button id="kt_progress_payment_toggle" class="progress-payment-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0" title="İndirilebilir Dosyalar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
				<span id="kt_progress_payment_label">Hakedişler</span>
			</button>
			<!--end::Demos drawer toggle-->
		</div>
	<!--end::Progress Payment toolbar-->
    <div id="kt_progress_payment" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'lg': '475px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_progress_payment_toggle" data-kt-drawer-close="#kt_progress_payment_close">
        <!--begin::Card-->
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_progress_payment_header">
                <h3 class="card-title fw-bold text-gray-700">İndirilebilir Dosyalar</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary h-40px w-40px me-n6" id="kt_progress_payment_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" id="kt_progress_payment_body">
                <!--begin::Content-->
                <div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_progress_payment_body" data-kt-scroll-dependencies="#kt_progress_payment_header" data-kt-scroll-offset="5px">
                    <!--begin::Wrapper-->
                    <div class="mb-0">
                        @if(count($dates) > 0)
                            @foreach ($dates as $item)
                                <div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="fs-6 fw-semibold text-gray-800 fw-semibold mb-0 me-1">{{ $item->faturalanma_tarihi }}</div>
                                            </div>
                                        </div>
                                        <div class="text-nowrap">
                                            <form method="POST" action="{{ route('returns.repair.progress_payment_download') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{ $item->faturalanma_tarihi }}" name="faturalanma_tarihi">
                                                <button type="submit" class="btn btn-sm btn-success">İndir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            Herhangi bir indirilecek dosya bulunmamaktadır.
                        @endif
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Container-->
@endsection

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <!--end::Vendors Javascript-->
    <script>
        $('#create_list').click(function() {
            var count = $('input:checkbox:checked').length;
            if(count > 0) {
                var choosen = [];
                $(".choosen").each(function(){
                    if ($(this).is(":checked")) {
                        choosen.push($(this).val());
                    }
                });
                choosen = choosen.toString();
                var count = choosen.split(',').length;
                if (confirm(count+' adet kayıt seçilmiştir. Listeyi oluşturmak istediğinize emin misiniz?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('returns.repair.create_progress_payment_list') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "choosen": choosen
                        },
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            } else {
                alert('Lütfen seçim yapınız!');
            }
        });
    </script>
@endsection