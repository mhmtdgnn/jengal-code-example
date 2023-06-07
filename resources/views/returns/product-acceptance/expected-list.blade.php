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
                <a href="{{ route('returns.create') }}" class="btn btn-primary">Talep Oluştur</a>
                <!--end::Add customer-->
            </div>
            <!--end::Card toolbar-->
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
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_category_table .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="w-100px">Talep Kodu</th>
                        <th class="min-w-150px">Talep Etiketi</th>
                        <th class="min-w-150px">Sipariş Numarası</th>
                        <th class="min-w-150px">Tüketici</th>
                        <th class="min-w-150px">Talep Tarihi</th>
                        <th class="w-110px">Ürün Adedi</th>
                        <th class="text-end w-80px"><i class="bi bi-eye-fill"></i></th>
                        <th class="text-end w-80px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                    <!--begin::Table row-->
                    @foreach ($data as $item)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>
                            <small class="badge badge-primary">{{ $item->line_type }}</small>
                        </td>
                        <td>{{ $item->order_number }}</td>
                        <td>{{ $item->store_name}} - {{ $item->customer }}</td>
                        <td><small>{{ $item->created_at->format('d.m.Y H:i') }}</small></td>
                        <td class="text-center">{{ $item->adet }}</td>
                        <td class="text-center">
                            @if($item->line_type == 'YENİGİBİAL İADE' or $item->line_type == 'YENİGİBİAL İPTAL' or $item->line_type == 'YENİGİBİAL DEĞİŞİM')
                                <span data-id="{{ $item->id }}" class="btn btn-sm btn-light-primary btn-active-light-info request-detail">
                                    <i class="bi bi-eye-fill"></i>
                                </span>
                            @endif
                        </td>
                        <!--begin::Action=-->
                        <td class="text-end">
                            <span data-id="{{ $item->id }}" data-type="{{ $item->type }}"
                                class="btn btn-sm btn-light-primary btn-active-light-info product-acceptance-accept">
                                <span class="indicator-label">
                                    TESLİM AL
                                </span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </span>
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

@section('extra_content')
    <form action="{{ route('returns.product_acceptance.accept') }}" method="POST" id="product-acceptance-accept-form">
        @csrf
        <input type="hidden" name="talep_id">
        <input type="hidden" name="talep_type">
    </form>
    <div class="modal fade" tabindex="-1" id="show_detail_modal">
        <div class="modal-dialog modal-dialog-centered modal-xl ajax-content">
            {{-- modal content --}}
        </div>
    </div>
    <div id="html_templates" class="d-none">
        <div class="modal-spinners w-100 d-flex justify-content-center align-items-center">
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary mx-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <!--end::Vendors Javascript-->
    <script>
        $(document).on('click', '.product-acceptance-accept', function () {
            let button = $(this);
            let talepID = $(this).data('id');
            let talepType = $(this).data('type');
            let form = $('#product-acceptance-accept-form');

            button.attr('data-kt-indicator', 'on');

            $('#product-acceptance-accept-form input[name="talep_id"]').val(talepID);
            $('#product-acceptance-accept-form input[name="talep_type"]').val(talepType);

            form.submit();
        });

        $(document).on('click', '.request-detail', function() {
            let dataID = $(this).data('id');

            let spinner = $('#html_templates .modal-spinners').clone();

            $('#show_detail_modal .ajax-content').html(spinner);
            $('#show_detail_modal').modal('show');

            $.ajax({
                type: "POST",
                url: "{{ route('returns.general.detail') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: dataID,
                    action_type: 'return'
                },
                success: function(response) {
                    $('#show_detail_modal .ajax-content').fadeOut(250, function() {
                        $(this).html(response).fadeIn(250);
                    });
                }
            });
            // toastr.error("Özellik Hazırlanıyor");
        });
    </script>
@endsection
