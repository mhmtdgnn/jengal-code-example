<form id="modal_update_transfer_method_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
    action="{{ route('bicozumExpress.vorwerkOrderUpdateTransferMethod') }}" method="POST">
    @csrf
    <div class="mb-13 text-center">
        <h1 class="mb-3 text-gray-700">Transfer Onayı</h1>
    </div>
    <div class="d-flex flex-column mb-4 fv-row">
        <select class="form-select form-select-solid" name="transfer" required>
            <option value="">Transfer Yöntemi Seçiniz...</option>
            <option value="UPS" @if($order->transfer_yontemi == 'UPS') selected @endif>UPS Kargo</option>
            <option value="BİÇÖZÜM" @if($order->transfer_yontemi == 'BİÇÖZÜM') selected @endif>BiÇözüm</option>
            <option value="YOK" @if($order->transfer_yontemi == 'YOK') selected @endif>Yok</option>
        </select>
    </div>
    <div class="d-flex flex-column mb-8">
        <textarea class="form-control form-control-solid" rows="4" name="note_onay"
            placeholder="Onay Notu(Opsiyonel)"></textarea>
    </div>
    <div class="mb-13">
        <div class="text-muted fw-semibold fs-6">
            Sipariş transfer yöntemini onaylamak üzeresiniz. Bu işleme devam etmek istediğinizden emin misiniz?
        </div>
    </div>
    <div class="text-center">
        <input type="hidden" value="{{ $order->id }}" name="order_id" id="order_id">
        <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
        <button type="submit" id="modal_update_transfer_method_form_submit" class="btn btn-primary">
            <span class="indicator-label">Evet</span>
            <span class="indicator-progress">
                Lütfen Bekleyiniz...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</form>