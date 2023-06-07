<div class="card card-flush">
    <div class="card-body">
        <div class="position-absolute top-0 start-50 translate-middle">
            <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                <form id="barcode_form">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-1 fw-semibold mb-2">
                        <span>BARKOD</span>
                    </label>
                    <!--end::Label-->
                    <input type="text" class="form-control w-500px p-10" placeholder="Lütfen barkodu okutunuz" name="serial_code" id="serial_code" required>
                    <input type="hidden" value="{{ $order->id }}" name="order_id" id="order_id">
                    <div class="position-absolute me-10 end-0 translate-middle-y me-2 warranty-spinner" style="top:65%; display: none;">
                        <div class="spinner-border text-info" style="display: block;" role="status">
                            <span class="visually-hidden">Bekleyiniz...</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(!empty($order->product_serial_numbers))
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-20" id="kt_ecommerce_category_table">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-30px">Sipariş Numarası</th>
                    <th class="min-w-150px">Ürün Seri Numarası</th>
                    <th class="min-w-150px">İşlem</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
                @php
                    $serials = json_decode($order->product_serial_numbers, true);
                @endphp
                @foreach ($serials as $item)
                    <tr>
                        <td>{{ $order->siparis_kodu }}</td>
                        <td>{{ $item }}</td>
                        <td>
                            <button type="button" name="remove" class="btn btn-light-danger btn-sm px-3 py-1 me-2 mb-2 serial_remove" data-id="{{ $order->id }}" data-serial="{{ $item }}">
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