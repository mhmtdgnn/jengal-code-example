@extends('common.layout')

@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-info">
                    {{ session('msg') }}
                </div>
            @endif
            <!--begin::Heading-->
            <div class="card-px text-center pt-15 pb-15">
                <!--begin::Title-->
                <h2 class="fs-2x fw-bold mb-0">Excel Listesi Yükle</h2>
                <!--end::Title-->
                <!--begin::Description-->
                <p class="text-gray-400 fs-4 fw-semibold py-7">Kargo kodlarınızı Excel listesi ile yükleyebilirsiniz.</p>
                <!--end::Description-->
                <!--begin::Action-->
                <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#modal_import">
                    <i class="fas fa-file-import"></i> Dosya Yükle
                </a>
                <!--end::Action-->
            </div>
            <!--end::Heading-->
            <!--begin::Illustration-->
            <div class="text-center pb-15 px-5">
                <img src="{{ asset('assets/media/illustrations/sigma-1/17.png') }}" alt="" class="mw-100 h-200px h-sm-325px" />
            </div>
            <!--end::Illustration-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->
<!-- begin:Modal Excel Import -->
<div class="modal fade" tabindex="-1" id="modal_import">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('returns.ygaCargoManagementImport') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>Excel ile Kargo Kodu Yükle</h3>
                </div>
                <div class="modal-body">
                    <div id="upload">
                        @csrf
                        <label for="importFile">Lütfen yüklemek istediğiniz belgeyi seçiniz.</label>
                        <input type="file" id="importFile" class="form-control" name="importFile">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary" id="import_excel_import_form_button">
                        <span class="indicator-label">
                            YÜKLE
                        </span>
                        <span class="indicator-progress">
                            Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end:Modal Excel Import -->
@endsection

@section('footer_scripts')
<script>
    $(document).on('click', '#import_excel_import_form_button', function () {
        let button = $(this);
        button.attr("data-kt-indicator", "on");
    });
</script>
@endsection