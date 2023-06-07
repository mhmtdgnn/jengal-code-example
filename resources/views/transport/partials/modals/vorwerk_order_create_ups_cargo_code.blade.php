<div class="card card-flush">
    <div class="card-body">
        <div class="position-absolute top-0 start-50 translate-middle" style="margin-top: -25px">
            <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                <form action="{{ route('bicozumExpress.createSingleUPSCargoCode') }}" method="POST" id="create_ups_cargo_code_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control text-center p-7" name="numberOfPackage" placeholder="Paket Sayısı" value="1" required>
                        </div>
                        <div class="col-md-8">
                            <!--end::Label-->
                            <button type="submit" class="btn btn-primary p-7" id="create_ups_cargo_code_form_button">
                                <span class="indicator-label">
                                    Yeni Kargo Kodu Oluştur
                                </span>
                                <span class="indicator-progress">
                                    Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <input type="hidden" value="{{ $order->id }}" name="order_id" id="order_id">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(!empty($order->cargoCodes))
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-20" id="kt_ecommerce_category_table">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-center text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-30px">Sipariş Numarası</th>
                    <th class="min-w-150px">Kargo Kodu</th>
                    <th class="min-w-150px">Kargo Etiketi</th>
                    <th class="min-w-150px">İşlem</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
                @foreach ($order->cargoCodes as $item)
                    <tr>
                        <td class="text-center">{{ $order->siparis_kodu }}</td>
                        <td class="text-center">{{ $order->gonderi_takip_no }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-icon btn-circle btn-sm btn-light-info cargo_barcode" data-id="{{ $item->id }}">
                                <i class="fas fa-barcode"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" name="remove" class="btn btn-light-danger btn-sm px-3 py-1 me-2 mb-2 cargoCode_remove" data-id="{{ $item->id }}">
                                <i class="bi bi-trash pe-0"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
        @endif
    </div>
</div>