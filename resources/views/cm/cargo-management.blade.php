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
                    <input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="İade Kodlarında Ara" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Add customer-->
                <a href="#//" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_create_return_code">Yeni İade Kodu</a>
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-150px">Kargo Firması</th>
                        <th class="min-w-150px">Müşteri</th>
                        <th class="min-w-100px">Platform</th>
                        <th class="min-w-100px">İade Nedeni</th>
                        <th class="min-w-150px">Not</th>
                        <th class="min-w-150px"></th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                    <!--begin::Table row-->
                    @foreach ($returnCodes as $item)
                    <tr>
                        <td>
                            @if($item->cargo_comapny == "UPS")
                                <img width="50" src="https://i.pinimg.com/originals/8e/a0/0c/8ea00cc70f634adfd66cb1ed13d4ad53.png" alt=""> - {{ $item->return_code }}
                            @else
                                <img width="50" src=" https://seeklogo.com/images/M/Mng_Kargo-logo-3708A49380-seeklogo.com.png" alt=""> - {{ $item->return_code }}
                            @endif
                        </td>
                        <td>{{ $item->consumer }} <br> {{ $item->phone }}</td>
                        <td>{{ $item->platform }}</td>
                        <td>{{ $item->reason }}</td>
                        <td>{{ $item->note }}</td>
                        <td>
                            @if($item->cargo_comapny == "UPS")
                                <a href="https://wa.me/{{ $item->phone}}?&text=Sayın%20müşterimiz%20gönderinizi%2072Y72Y%20müşteri%20kodu%20ile%20UPS%20kargo%20şubelerinden%20tarafımıza%20gönderebilirsiniz.%20İyi%20günler%20dileriz."> <img width="50" src="https://i.hizliresim.com/GosSLT.jpg" alt=""></a><
                            @else
                                <a href="https://wa.me/{{ $item->phone}}?&text=Sayın%20müşterimiz%20gönderinizi%20345309865%20cari%20kodu%20ve%20{{ $item->return_code }}%20iade%20onay%20kodu%20ile%20MNG%20şubelerine%20teslim%20edebilirsiniz.%20İyi%20günler%20dileriz."> <img width="50" src="https://i.hizliresim.com/GosSLT.jpg" alt=""></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
            {{ $returnCodes->links() }}
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Category-->
</div>
<!--end::Container-->
@endsection
@section('extra_content')
    <div class="modal fade" id="modal_create_return_code" tabindex="-1">
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
                    <form id="modal_create_return_code_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                        action="{{ route('cm.createReturnCode') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">İade Kodu Oluştur</h1>
                        </div>
                        <div class="d-flex flex-column mb-4 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Kargo Firması Seçiniz" name="cargo_company" id="cargo_company">
                                <option value="">Seçiniz</option>
                                <option value="UPS">UPS KARGO</option>
                                <option value="MNG">MNG KARGO</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-4 fv-row">
                            <input type="text" class="form-control form-control-solid"
                                placeholder="Adı Soyadı" 
                                name="consumer" autocomplete="off"/>
                        </div>
                        <div class="d-flex flex-column mb-4 fv-row">
                            <input type="text" id="to-phone" 
                                class="form-control form-control-solid"
                                placeholder="(___) ___-____" 
                                name="phone" required/>
                        </div>
                        <div class="d-flex flex-column mb-4 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Platform Seçiniz" name="platform" id="platform">
                                <option value="">Seçiniz...</option>
                                <option value="BİCOZUM.COM">BİCOZUM.COM</option>
                                <option value="BİCOZUM OPERASYON">BİCOZUM OPERASYON</option>
                                <option value="VORWERK">VORWERK</option>
                                <option value="DİĞER">DİĞER</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-4 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="İade Nedeni Seçiniz" name="reason" id="reason">
                                <option value="">Seçiniz...</option>
                                <option value="EKSİK ÜRÜN">EKSİK ÜRÜN</option>
                                <option value="FAZLA ÜRÜN">FAZLA ÜRÜN</option>
                                <option value="KIRIK ÜRÜN">KIRIK ÜRÜN</option>
                                <option value="YANLIŞ ÜRÜN">YANLIŞ ÜRÜN</option>
                                <option value="DİĞER">DİĞER</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <textarea class="form-control form-control-solid" rows="5" name="note" id="note" placeholder="Mesaj"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                            <button type="submit" id="modal_create_return_code_submit" class="btn btn-primary">
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

        $(document).on('click', '#modal_create_return_code_submit', function() {
            $(this).attr("data-kt-indicator", "on");
        });
    </script>
@endsection