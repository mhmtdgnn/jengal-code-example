@extends('common.layout')

@section('content')
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card toolbar-->
                <div class="card-toolbar d-flex justify-content-end w-100">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <button type="button" class="btn btn-light-primary me-3" id="create_list">
                            Hakediş Listesi Oluştur
                        </button>
                    </div>
                    <!--end::Toolbar-->
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" id="checkAll" data-kt-check-target="#kt_ecommerce_category_table .form-check-input"/>
                                </div>
                            </th>
                            <th class="w-125px">Sipariş Kodu</th>
                            <th class="w-75px">Oluşturma Tarihi</th>
                            <th class="w-50px">Adet</th>
                            <th class="w-125px">Durum</th>
                            <th class="w-150px">Müşteri</th>
                            <th class="w-200px">Teslimat İl/İlçe</th>
                            <th class="w-50px">Hediye Ürün</th>
                            <th class="w-50px">Transfer Yöntemi</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($orders as $item)
                        <tr class="item-{{ $item->id }}">
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input choosen" type="checkbox" value="{{$item->id}}" />
                                </div>
                            </td>
                            <td>
                                <small class="text-info">{{ $item->siparis_kodu }}</small>
                            </td>
                            <td><small class="text-ligth">{{ $item->created_at->format('Y-m-d') }}</small></td>
                            <td><small class="text-info">{{ $item->detail->count() }}</small></td>
                            <td>
                                <div class="badge @if($item->durum == 3) badge-danger @else badge-info @endif"><small>{{ $item->statu->title }}</small></div>
                            </td>
                            <td>
                                <small class="text-gray-600 text-hover-primary mb-1">
                                    @if(!empty($item->teslimat_isim) OR !empty($item->teslimat_soyisim))
                                    {{ mb_strtoupper(@$item->teslimat_isim) . ' ' . mb_strtoupper(@$item->teslimat_soyisim) }}
                                    @else
                                    {{ mb_strtoupper(@$item->consumer->firstName) . ' ' . mb_strtoupper(@$item->consumer->lastName) }}
                                    @endif
                                    <small class="fs-7x text-info d-block">{{ @$item->consumer->phone }}</small>
                                </small>
                            </td>
                            <td class="position-relative bg-light pe-10">
                                <div class="district">
                                    @if(!empty($item->teslimat_il_ups))
                                        <small>{{ $item->ups_il->city_name }}</small>
                                    @else
                                        <small class="text-danger">-</small>
                                    @endif
                                    /
                                    @if(!empty($item->teslimat_ilce_ups))
                                        <small>{{ $item->ups_ilce->area_name }}</small>
                                    @else
                                        <small class="text-danger">-</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($item->hediye_urun == 1)
                                    <span role="button" class="badge badge-primary">Evet</span>
                                @else
                                    <span role="button" class="badge badge-danger">Hayır</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ @$item->transfer_yontemi }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
                {{ $orders->links() }}
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
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
                                            <form method="POST" action="{{ route('bicozumExpress.vorwerkOrderProgressPaymentDownload') }}">
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
@endsection

@section('footer_scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <script>
        /**
        * Genel Fonksiyon ve Ayarlar
        */
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        
        $('#create_list').click(function() {
            var count = $('input:checkbox:checked').length;
            if (count > 0) {
                var choosen = [];
                $(".choosen").each(function(){
                    if ($(this).is(":checked")) {
                        choosen.push($(this).val());
                    }
                });
                choosen = choosen.toString();
                var count = choosen.split(',').length;
                Swal.fire({
                    title: count+' adet kayıt seçilmiştir. Listeyi oluşturmak istediğinize emin misiniz?',
                    text: "Siparişler için hakediş listesi oluşturulacaktır.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7239ea',
                    cancelButtonColor: '#f1416c',
                    confirmButtonText: 'Evet, onaylıyorum.',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('bicozumExpress.vorwerkOrderCreateProgressPaymentList') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "choosen": choosen
                            },
                            success: function(data) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Hakediş Listesi Başarıyla Oluşturuldu.'
                                }).then((result) => {
                                    location.reload(); 
                                });
                            }
                        });
                    }
                });
            } else {
                toastr.error("Lütfen seçim yapınız");
            }
        });
    </script>
@endsection