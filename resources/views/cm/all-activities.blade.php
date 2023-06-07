@extends('common.layout')

@section('content')
    <div class="container-xxl">
         <!--begin::Card-->
         <div class="card min-h-600px">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-15" placeholder="Taleplerde Ara" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <pre>
                    {{-- {{ print_r($activities) }} --}}
                </pre>
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Aktivite No</th>
                            <th class="min-w-125px">Aktivite Case</th>
                            <th class="min-w-125px">Aktivite Konusu</th>
                            <th class="min-w-125px">Hissiyat</th>
                            <th class="min-w-125px">Oluşturan</th>
                            <th class="min-w-125px">Aktivite Tarihi</th>
                            <th class="text-end min-w-70px">İşlem</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($activities as $item)
                        <tr>
                            <td>
                                <span class="text-info">#{{ $item->activity_id }}</span>
                            </td>
                            <td><span class="badge badge-success">{{ $item->activity_case }}</span></td>
                            <td>{{ $item->activity_subject }}</td>
                            <td>
                                @switch($item->activity_sense)
                                    @case(1)
                                        <i class="far fa-smile-beam fs-3x text-success"></i>
                                        @break
                                    @case(2)
                                        <i class="far fa-meh fs-3x text-muted"></i>
                                        @break
                                    @case(3)
                                        <i class="far fa-frown-open fs-3x text-dark"></i>
                                        @break
                                    @case(4)
                                        <i class="far fa-angry fs-3x text-danger"></i>
                                        @break
                                @endswitch
                            </td>
                            <td><small class="text-info">{{ $item->created_user }}</small></td>
                            <td><small class="text-muted">{{ $item->activity_created_at }}</small></td>
                            <td class="text-end">
                                <span data-consumer-id="{{ $item->consumer_id }}" data-activity-id="{{ $item->activity_id }}"
                                    class="btn btn-sm btn-light-primary btn-active-light-primary show-activity-detail">
                                    <span class="indicator-label">
                                        İNCELE
                                    </span>
                                    <span class="indicator-progress">
                                        <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer">
                {{ $activities->links() }}
            </div>
            <!--end::Card footer-->
        </div>
        <!--end::Card-->
    </div>
@endsection

@section('extra_content')
    <form action="{{ route('cm.activityDetail') }}" method="POST" id="activity_detail_show_form">
        @csrf
        <input type="hidden" name="activity_id">
        <input type="hidden" name="consumer_id">
    </form>
@endsection

@section('footer_scripts')
    <script>
        $(document).on('click', '.show-activity-detail', function () {
            let button = $(this);
            let activityID = $(this).data('activity-id');
            let consumerID = $(this).data('consumer-id');
            let form = $('#activity_detail_show_form');
            
            button.attr('data-kt-indicator', 'on');
            
            $('#activity_detail_show_form input[name="activity_id"]').val(activityID);
            $('#activity_detail_show_form input[name="consumer_id"]').val(consumerID);
            
            form.submit();
        });
    </script>
@endsection