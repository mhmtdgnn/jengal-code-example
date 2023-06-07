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
                    <input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="SMSlerde Ara" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Add customer-->
                <a href="#//" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_send_sms">Yeni SMS</a>
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
                        <th class="w-100px">SMS Kodu</th>
                        <th class="min-w-150px">Gönderen</th>
                        <th class="min-w-150px">Gönderilen</th>
                        <th class="min-w-150px">Tarih</th>
                        <th class="min-w-150px">Mesaj</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                    <!--begin::Table row-->
                    @foreach ($messages as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->to }}</td>
                        <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $item->message }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
            {{ $messages->links() }}
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Category-->
</div>
<!--end::Container-->
@endsection
@section('extra_content')
    <div class="modal fade" id="modal_send_sms" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="modal_send_sms_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        action="{{ route('cm.sendSMS') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">SMS Gönder</h1>
                        </div>
                        <div class="d-flex flex-column mb-4 fv-row">
                            <input type="text" id="to-phone"
                                class="form-control form-control-solid"
                                placeholder="(___) ___-____"
                                name="tocustomer" required/>
                        </div>
                        <div class="d-flex flex-column mb-4 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="SMS Şablonu Seçiniz" name="smslayout" id="smslayout">
                                <option value="">SMS Şablonu Seçiniz...</option>
                                <option value="1">Arzum Ulaşılamayan Müşteri</option>
                                <option value="2">Hakman Ulaşılamayan Müşteri</option>
                                <option value="3">Enplus Ulaşılamayan Müşteri</option>
                                <option value="4">E-Ticaret Sipariş Teslimi</option>
                                <option value="5">Servis Süreci</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <textarea class="form-control form-control-solid" rows="5" name="message" id="message" placeholder="Mesaj" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                            <button type="submit" id="modal_send_sms_submit" class="btn btn-primary">
                                <span class="indicator-label">Evet</span>
                                <span class="indicator-progress">
                                    Lütfen Bekleyiniz...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
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
        Inputmask({
            "mask" : "(999) 999-9999",
            "placeholder": "(___) ___-____",
        }).mask("#to-phone");

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });


        $("#smslayout").on('change', function() {
            if(this.value =='1'){
                $("#message").val('Merhaba, Arzum Evden Eve talebiniz ile ilgili tarafınıza arama yaptık ancak ulaşamadık. Randevu oluşturmak için 0216 428 9090 numaradan bizimle iletişime geçebilirsiniz. Teşekkürler,');
            }
            if(this.value =='2'){
                $("#message").val('Merhaba, Hakman arızalı ürününüzün adresinizden alımı için tarafınıza arama yaptık ancak ulaşamadık. Randevu oluşturmak için 0216 428 9090 numaradan bizimle iletişime geçebilirsiniz. Teşekkürler,');
            }
            if(this.value =='3'){
                $("#message").val('Merhaba, Enplus arızalı ürününüzün adresinizden alımı için tarafınıza arama yaptık ancak ulaşamadık. Randevu oluşturmak için 0216 428 9090 numaradan bizimle iletişime geçebilirsiniz. Teşekkürler,');
            }
            if(this.value =='4'){
                $("#message").val('Merhaba, Yenigibial.com siparişiniz tarafınıza teslim edilmek üzere satıcıdan teslim alınmıştır. 3 iş günü içerisinde adresinize teslim edilecektir. Teşekkürler,');
            }
            if(this.value =='5'){
                $("#message").val('Merhaba, Serviste bulunan ürününüz ile ilgili tarafınıza arama yaptık ancak ulaşamadık. Bilgi almak için 0216 428 9090 numaradan bizimle iletişime geçebilirsiniz. Teşekkürler,');
            }
        });

        $(document).on('click', '#modal_send_sms_submit', function() {
            $(this).attr("data-kt-indicator", "on");
        });
    </script>
@endsection
