@extends('common.layout')
@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <!--begin::Title-->
            <div class="d-flex justify-content-between align-items-center flex-wrap py-8">
                <!--begin::store-->
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-info p-3 me-2">{{ $claim->id }}</span>
                        <span class="text-gray-700 fs-2 fw-bold me-1">Mağaza ve Talep Bilgileri</span>
                    </div>
                </div>
                <!--end::store-->
            </div>
            <!--end::Title-->
        </div>
        <div class="card-body pt-9 pb-0">
            <div class="row mb-12">
                <div class="col-lg-4">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5">
                                Müşteri
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <div class="d-block align-items-center">
                            {{ $claim->consumer->firstName.' '.$claim->consumer->lastName }}
                        </div>
                        <div class="d-block align-items-center">
                            {{ $claim->consumer->phone }}
                        </div>
                        <div class="d-block align-items-center">
                            {{ $claim->consumer->email }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5">
                                Talebi Açan
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <div class="d-block align-items-center">
                            <span class="d-block">{{ $claim->user->name }}</span>
                            <span class="d-block">{{ $claim->user->gsm }}</span>
                            <span class="d-block">{{ $claim->user->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="h-100 p-5 pb-8 border border-gray-300 border-dashed rounded bg-light">
                        <!--begin::Underline-->
                        <span class="d-inline-block position-relative mb-4">
                            <span class="d-inline-block mb-1 fs-5">
                                Tarih / Saat
                            </span>
                            <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                        </span>
                        <!--end::Underline-->
                        <div class="d-block align-items-center">
                            {{ $claim->created_at->format('d-m-Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            @if (session('msg'))
                <div class="alert alert-info">
                    {{ session('msg') }}
                </div>
            @endif
            <!--begin::Navs-->
            <div class="stepper stepper-pills" id="kt_create_ayristirma">
                <div class="stepper-nav flex-center flex-wrap mb-10">
                    <div class="stepper-item mx-2 my-4 current" data-kt-stepper-element="nav">
                        <div class="stepper-line w-40px"></div>
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">1</span>
                        </div>
                        <div class="stepper-label">
                            <h3 class="stepper-title">Ürün Bilgileri</h3>
                            <div class="stepper-desc">Ürün Bilgisi Giriniz</div>
                        </div>
                    </div>
                    <div class="stepper-item" data-kt-stepper-element="nav">
                        <div class="stepper-line w-40px"></div>
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">2</span>
                        </div>
                        <div class="stepper-label">
                            <h3 class="stepper-title">Yedek Parça Seçimi</h3>
                            <div class="stepper-desc">Yedek Parça Bilgisi Giriniz</div>
                        </div>
                    </div>
                    <div class="stepper-item" data-kt-stepper-element="nav">
                        <div class="stepper-line w-40px"></div>
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">3</span>
                        </div>
                        <div class="stepper-label">
                            <h3 class="stepper-title">İris Kodları</h3>
                            <div class="stepper-desc">İris Bilgisi Giriniz</div>
                        </div>
                    </div>
                </div>
                <form
                    action="{{ route('service.claim.save') }}"
                    method="POST"
                    class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    id="ayristirmaFormu"
                    novalidate="novalidate"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <div class="flex-column current" data-kt-stepper-element="content">
                            @csrf
                            <input type="hidden" id="claim_detail_id" name="claim_detail_id" value="{{ $claim->service_claim_detail->id }}">
                            <input type="hidden" name="claim" value="{{ $claim->id }}">
                            <div class="w-100">
                                <div class="fv-row mb-3 fv-plugins-icon-container">
                                    <div class="separator separator-dashed border-primary mb-10"></div>
                                    <div class="row my-8">
                                        <div class="col-md-4">
                                            <label class="fw-bolder" for="product_name">Ürün adı</label>
                                            <br>
                                            <span id="product_name">{{ $claim->service_claim_detail->product_name }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fw-bolder" for="product_code">Ürün Kodu</label>
                                            <br>
                                            <span id="product_code">{{ $claim->service_claim_detail->product_code }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fw-bolder" for="product_iris">Ürün Ailesi</label>
                                            <br>
                                            <span id="product_iris">{{ @$product_iris->iris_kategori_description }}</span>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed border-primary my-10"></div>
                                    <div class="row my-8">
                                        <div class="col-md-4">
                                            <label for="satin_alinan_magaza">Satın Alınan Mağaza</label>
                                            <select data-control="select2"
                                            data-placeholder="Mağaza Seçiniz"
                                            id="satin_alinan_magaza"
                                            name="satin_alinan_magaza"
                                            class="form-control select-search">
                                                <option></option>
                                                @foreach($stores as $item)
                                                    <option value="{{ $item->musteri_kodu }}" @if ($item->musteri_kodu == $claim->service_claim_detail->store_bought) selected="selected" @endif>
                                                        {{ $item->musteri_kodu}} {{ $item->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Garanti Devam Ediyor Mu?</label>
                                            <select name="garantili_mi" id="garantili_mi" class="form-select form-select-solid">
                                                <option value="-1">Seçiniz</option>
                                                <option value="1" @if ($claim->service_claim_detail->hasWarranty == 1) selected="selected" @endif>Garanti Süresi İçinde</option>
                                                <option value="0" @if ($claim->service_claim_detail->hasWarranty == 0) selected="selected" @endif>Garanti Süresi Dışında</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="satis_tarihi">Satış Tarihi</label>
                                            <input
                                            class="form-control form-control-solid satis_tarihi"
                                            id="satis_tarihi"
                                            inputmode="text"
                                            name="satis_tarihi"
                                            value="{{ $claim->service_claim_detail->sale_date }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="garanti_belgesi_kodu">Garanti Kodu</label>
                                            <input
                                                type="text"
                                                name="garanti_belgesi_kodu"
                                                id="garanti_belgesi_kodu"
                                                placeholder="Garanti Kodu"
                                                class="form-control form-control-solid"
                                                maxlength="10"
                                                value="{{ $claim->service_claim_detail->warrant_code }}">
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed border-primary my-10"></div>
                                    <div class="row my-8">
                                        <div class="col-md-4">
                                            <textarea
                                                class="form-control form-control-solid"
                                                id="tuketici_sikayet"
                                                placeholder="Tüketici Şikayeti"
                                                name="tuketici_sikayet">{{ $claim->service_claim_detail->description }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <textarea
                                                class="form-control form-control-solid"
                                                id="servis_notu"
                                                placeholder="Servis Notu"
                                                name="servis_notu"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <textarea
                                                class="form-control form-control-solid"
                                                id="servis_dahili_notu"
                                                placeholder="Servis Dahili Notu"
                                                name="servis_dahili_notu"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="fv-row fv-plugins-icon-container mb-5">
                                    <div class="bg-light rounded border p-4">
                                        <span class="d-inline-block position-relative mb-4">
                                            <span class="d-inline-block mb-1 fs-3 fw-bold">
                                                Parça Ekle
                                            </span>
                                            <span class="d-inline-block position-absolute h-6px bottom-0 end-0 start-0 bg-success translate rounded"></span>
                                        </span>
                                        <div class="form-group row">
                                            <div class="col-md-7">
                                                <select
                                                    data-control="select2"
                                                    data-placeholder="Yedek Parça Seçiniz"
                                                    class="form-control select-search"
                                                    name="part"
                                                    id="part">
                                                    <option></option>
                                                    @foreach ($parts as $item)
                                                        <option value="{{ $item->parts_sap_code }}">{{ $item->parts_sap_code }} {{ $item->parts_product_code }} {{ $item->parts_product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="parca_garantili_mi" id="parca_garantili_mi" class="form-select" placeholder="Garanti Durumu">
                                                    <option>Seçiniz</option>
                                                    <option value="1">Garanti Dahili</option>
                                                    <option value="0">Garanti Harici</option>
                                                </select>
                                                <label for="part">
                                                    <small class="text-muted">
                                                        <i class="bi bi-info-circle-fill"></i>
                                                        Parça Garanti Dahilinde Mi Değişecek?
                                                    </small>
                                                </label>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <a href="#" id="add_parts" name="add_parts" class="btn btn-sm btn-info px-8">EKLE</a>
                                            </div>
                                        </div>

                                        <div class="table px-6 my-6" id="claimDetailParts">
                                            <table class="table align-middle table-row-bordered table-row-gray-300" id="parts_table">
                                                <thead>
                                                    <tr class="fw-bolder fs-6 text-gray-800">
                                                        <th>Parça SAP Kodu</th>
                                                        <th>Parça Kodu</th>
                                                        <th>Parça Adı</th>
                                                        <th>Garanti Durumu</th>
                                                        <th>Fiyat</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($addedParts as $item)
                                                    <tr id="row{{ $item->id }}">
                                                        <td>{{ $item->parts_sap_code }}</td>
                                                        <td>{{ $item->parts_detail->parts_product_code }}</td>
                                                        <td>{{ $item->parts_detail->parts_product_name }}</td>
                                                        <td>@if($item->garanti == 0) Garanti Harici @else Garanti Dahili @endif</td>
                                                        <td>{{ $item->parts_detail->parts_prices }} ₺</td>
                                                        <td><button type="button" name="remove" id="{{ $item->id }}" class="btn btn-light-danger btn-sm px-3 py-1 me-2 mb-2 btn_remove_part"><i class="bi bi-trash pe-0"></i></button></td>
                                                    <tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row fv-plugins-icon-container">
                                    <div class="bg-white rounded border p-4">
                                        <div class="row mb-5">
                                            <div class="col-md-6">
                                                <div class="card shadow-sm">
                                                    <h3 class="card-title fw-bolder text-gray-700 m-5 mb-0">Harici Gider</h3>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="harici_gider">Tip</label>
                                                                <select name="harici_gider" id="harici_gider" class="form-control">
                                                                    <option value="">Seçiniz</option>
                                                                    <option value="kargo">Kargo</option>
                                                                    <option value="eve_servis">Eve Servis</option>
                                                                    <option value="harici_parca">Harici Parça</option>
                                                                    <option value="diger">Diğer</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="harici_tutar">Tutar</label>
                                                                <input type="text" name="harici_tutar" id="harici_tutar" class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mt-5">
                                                                <a href="#" id="add_expense" name="add_expense" class="btn btn-success">Ekle</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="table px-6 my-6" id="claimDetailExpenses">
                                                    <table class="table align-middle table-row-bordered table-row-gray-300" id="expenses_table">
                                                        <thead>
                                                            <tr class="fw-bolder fs-6 text-gray-800">
                                                                <th>Tip</th>
                                                                <th>Tutar</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($addedExpenses as $item)
                                                            @php
                                                                if($item->expense_type == 'kargo') {
                                                                    $gider = 'Kargo';
                                                                } else if($item->expense_type == 'eve_servis') {
                                                                    $gider = 'Eve Servis';
                                                                } else if($item->expense_type == 'harici_parca') {
                                                                    $gider = 'Harici Parça';
                                                                } else {
                                                                    $gider = 'Diğer';
                                                                }
                                                            @endphp
                                                            <tr id="row{{ $item->id }}">
                                                                <td>{{ $gider }}</td>
                                                                <td>{{ $item->expense_amount }} ₺</td>
                                                                <td>
                                                                    <button type="button" name="remove" id="{{ $item->id }}" class="btn btn-light-danger btn-sm px-3 py-1 me-2 mb-2 btn_remove_expense">
                                                                        <i class="bi bi-trash pe-0"></i>
                                                                    </button>
                                                                </td>
                                                            <tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="fv-row fv-plugins-icon-container">
                                    <div class="row mb-5">
                                        {{--  Aile Kodları --}}
                                        <div class="col-md-4">
                                            <div class="bg-light p-4 rounded h-100">
                                                <span class="d-inline-block position-relative">
                                                    <span class="d-inline-block mb-1 fs-2 fw-bold">
                                                        Aile Kodları
                                                    </span>
                                                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-success translate rounded"></span>
                                                </span>
                                                <div class="row my-5">
                                                    <label class="col-form-label ms-1 mb-1">İris Kodları</label>
                                                    <div class="familyCode">
                                                        @if(!empty($product_iris->iris_kategori))
                                                            <select name="iris" id="iris" class="form-control" disabled>
                                                                <option>{{ @$product_iris->iris_kategori_description }}</option>
                                                            </select>
                                                        @else
                                                            <span class="form-text text-muted">İris tanımlı değil</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--  Müşteri Nededi --}}
                                        <div class="col-md-4">
                                            <div class="bg-light p-4 rounded h-100">
                                                <span class="d-inline-block position-relative">
                                                    <span class="d-inline-block mb-1 fs-2 fw-bold">
                                                        Müşteri Ne Dedi?
                                                    </span>
                                                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-primary translate rounded"></span>
                                                </span>
                                                <div class="row my-5">
                                                    <div class="col-lg-12">
                                                        <select name="musteri_nededi" id="musteri_nededi" class="form-control" disabled>
                                                            <option value="{{ $claim->service_claim_detail->symptom_category }}">{{ $claim->service_claim_detail->symptom_category }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-lg-12">
                                                        <div id="musteri_nededi_iris">
                                                            <select id="musteri_nededi_iris_x" name="musteri_nededi_iris_x" class="form-control" disabled>
                                                                <option value="{{ $claim->service_claim_detail->symptom_code }}">{{ $claim->service_claim_detail->symptom_code }}</option>
                                                            </select>
                                                        </div>
                                                        <small class="form-text d-block text-gray-600 mt-4">
                                                            <i class="bi bi-info-lg"></i>
                                                            Şikayet kodu (Symptom Code): Tüketicinin ifade ettiği şikayeti tanımlar
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--  Neresi Arızalı --}}
                                        <div class="col-md-4">
                                            <div class="bg-light p-4 rounded h-100">
                                                <span class="d-inline-block position-relative">
                                                    <span class="d-inline-block mb-1 fs-2 fw-bold">
                                                        Neresi Arızalı?
                                                    </span>
                                                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-info translate rounded"></span>
                                                </span>
                                                <div class="row my-5">
                                                    <div class="col-lg-12">
                                                        <select name="neresi_arizali" id="neresi_arizali" class="form-control"  onchange="neresi(this);">
                                                            <option value="0">Seçiniz</option>
                                                            @foreach ($neresi_arizali as $item)
                                                            <option value="{{ $item->iris_kategori_kod }}-{{ $item->iris_kategori_desc }}">{{ $item->iris_kategori_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-lg-12">
                                                        <div id="neresi_arizali_iris">
                                                            <select id="neresi_arizali_iris_x" name="neresi_arizali_iris_x"  class="form-control">
                                                                <option value="">Seçiniz</option>
                                                            </select>
                                                        </div>
                                                        <span class="form-text d-block text-gray-600 mt-4">
                                                            <i class="bi bi-info-lg"></i>
                                                            Arıza kodu (Section Code): Arızanın cihazın hangi parçasında olduğunu tanımlar
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        {{--  Neden Arızalandı--}}
                                        <div class="col-md-4">
                                            <div class="bg-light p-4 rounded h-100">
                                                <span class="d-inline-block position-relative">
                                                    <span class="d-inline-block mb-1 fs-2 fw-bold">
                                                        Neden Arızalandı?
                                                    </span>
                                                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-danger translate rounded"></span>
                                                </span>
                                                <div class="row my-5">
                                                    <div class="col-lg-12">
                                                        <select name="neden_arizali" id="neden_arizali" class="form-control"  onchange="neden(this);">
                                                            <option value="0">Seçiniz</option>
                                                            @foreach ($neden_arizalandi as $item)
                                                            <option value="{{ $item->iris_kategori_kod }}-{{ $item->iris_kategori_desc }}">{{ $item->iris_kategori_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-lg-12">
                                                        <div id="neden_arizali_iris">
                                                            <select id="neden_arizali_iris_x" name="neden_arizali_iris_x"  class="form-control">
                                                                <option value="">Seçiniz</option>
                                                            </select>
                                                        </div>
                                                        <span class="form-text d-block text-gray-600 mt-4">
                                                            <i class="bi bi-info-lg"></i>
                                                            Teşhis kodu (Defect Code): Analiz sonucu tespit edilen parçanın arıza bilgisini tanımlar
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--  Nasıl Çözeceksin --}}
                                        <div class="col-md-4">
                                            <div class="bg-light p-4 rounded h-100">
                                                <span class="d-inline-block position-relative">
                                                    <span class="d-inline-block mb-1 fs-2 fw-bold">
                                                        Nasıl Çözeceksin?
                                                    </span>
                                                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-warning translate rounded"></span>
                                                </span>
                                                <div class="row my-5">
                                                    <div class="col-lg-12">
                                                        <select name="nasil_cozulecek" id="nasil_cozulecek" class="form-control"  onchange="nasil(this);">
                                                            <option value="0">Seçiniz</option>
                                                            @foreach ($nasil_cozulecek as $item)
                                                            <option value="{{ $item->iris_kategori_kod }}">{{ $item->iris_kategori_desc }}</option>
                                                            @endforeach</select>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-lg-12">
                                                        <div id="nasil_cozulecek_iris">
                                                            <select id="nasil_cozulecek_iris_x" name="nasil_cozulecek_iris_x"  class="form-control">
                                                                <option value="">Seçiniz</option>
                                                            </select>
                                                        </div>
                                                        <span class="form-text d-block text-gray-600 mt-4">
                                                            <i class="bi bi-info-lg"></i>
                                                            Çözüm kodu (Repair Code): Teknisyen tarafından yapılan onarım işlemini tanımlar
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="bg-light p-4 rounded h-100">
                                                <span class="d-inline-block position-relative">
                                                    <span class="d-inline-block mb-1 fs-2 fw-bold">
                                                        Tamir Bitti Mi?
                                                    </span>
                                                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-secondary translate rounded"></span>
                                                </span>
                                                <div class="row my-5">
                                                    <select name="tamir" id="tamir" class="form-control" >
                                                        <option value="">Seçiniz</option>
                                                        <option value="Bitti">Bitti</option>
                                                        <option value="Bitmedi">Bitmedi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="bg-light p-4 rounded h-100">
                                                <span class="d-inline-block position-relative">
                                                    <span class="d-inline-block mb-1 fs-2 fw-bold">
                                                        Talep Türü
                                                    </span>
                                                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-success translate rounded"></span>
                                                </span>
                                                <div class="row my-5">
                                                    <select name="claimType" id="claimType" class="form-control" disabled></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-stack pt-10">
                            <div class="me-2">
                                <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                    <span class="svg-icon svg-icon-3 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1"></rect>
                                                <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"></path>
                                            </g>
                                        </svg>
                                    </span>Geri
                                </button>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        Kaydet
                                        <span class="svg-icon svg-icon-3 ms-2 me-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                                    <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen Bekleyiniz...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                    İleri
                                    <span class="svg-icon svg-icon-3 ms-1 me-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer text-end">
            @if($claim->service_claim_detail->claim_type)
                <a href="#" class="btn btn-md btn-info me-3" data-bs-toggle="modal" data-bs-target="#modal_onayla">Kontrol Tamamlandı</a>
            @else
                <a href="#" class="btn btn-md btn-info me-3">Kontrol Tamamlanmadı</a>
            @endif
            @if($claim->service_claim_detail->claim_type == 'ase' and !empty($claim->service_claim_detail->shipping_date))
                <form action="{{ route('service.claim.cargo') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <label for="cargoNumber" class="visually-hidden">Kargo Numarası</label>
                            <input type="text" name="cargoNumber" class="form-control" id="cargoNumber" placeholder="Kargo Numarası" value="{{ $claim->service_claim_detail->cargo_number }}">
                        </div>
                        <div class="col-md-4 text-end">
                            <input type="hidden" name="claim_id" value="{{ $claim->id }}">
                            <button type="submit" class="btn btn-primary mb-3">Tamam</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    <!--end::Navbar-->
    <button id="kt_explore_toggle" class="btn btn-sm bg-body btn-color-gray-700 btn-active-primary shadow-sm position-fixed px-5 fw-bolder zindex-2 top-50 mt-10 end-0 transform-90 fs-6 rounded-top-0" title="Teslim Bilgileri" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover">
        <span id="kt_explore_toggle_label">Teslim Bilgileri</span>
    </button>
    <div id="kt_explore" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'lg': '475px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle" data-kt-drawer-close="#kt_explore_close">
        <div class="card shadow-none rounded-0 w-100">
            <div class="card-header" id="kt_explore_header">
                <h3 class="card-title fw-bolder text-gray-700">Teslim Bilgileri</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                                </g>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            <div class="card-body" id="kt_explore_body">
                <div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_explore_body" data-kt-scroll-dependencies="#kt_explore_header" data-kt-scroll-offset="5px">
                    <div class="mb-0">
                        <div class="mb-7">
                            <div class="d-flex flex-stack">
                                <h3 class="mb-0">Teslim Eden Bilgisi</h3>
                            </div>
                        </div>
                        <div class="separator separator-dashed border-dark my-3"></div>
                        <div id="kt_teslim_eden_bilgileri" class="collapse show">
                            <div class="py-1 mx-5 fs-7">
                                <div class="fw-bolder">Teslim Eden</div>
                                <div class="text-gray-600">
                                    @if($claim->service_claim_address->teslimEden == 'urunun_sahibi')
                                        Ürünün Sahibi
                                    @elseif($claim->service_claim_address->teslimEden == 'kargo')
                                        Kargo Şirketi
                                    @else
                                        Diğer
                                    @endif
                                </div>
                                @if($claim->service_claim_address->teslimEden == 'kargo')
                                    <div class="fw-bolder mt-5">Gönderen Ad Soyad</div>
                                    <div class="text-gray-600">{{ $claim->service_claim_address->gonderen_ad_soyad }}</div>
                                    <div class="fw-bolder mt-5">Kargo Şirketi</div>
                                    <div class="text-gray-600">
                                        @if($claim->service_claim_address->kargo_sirketi == 'aras_kargo')
                                            Aras Kargo
                                        @elseif($claim->service_claim_address->kargo_sirketi == 'surat_kargo')
                                            Sürat Kargo
                                        @elseif($claim->service_claim_address->kargo_sirketi == 'yurtici_kargo')
                                            Yurtiçi Kargo
                                        @elseif($claim->service_claim_address->kargo_sirketi == 'ptt_kargo')
                                            PTT Kargo
                                        @else
                                            Diğer
                                        @endif
                                    </div>
                                    <div class="fw-bolder mt-5">Kargo Takip No</div>
                                    <div class="text-gray-600">{{ $claim->service_claim_address->kargo_takip_no }}</div>
                                    <div class="fw-bolder mt-5">Kargo Teslim Tarihi</div>
                                    <div class="text-gray-600">{{ $claim->service_claim_address->kargo_teslim_tarihi }}</div>
                                    <div class="fw-bolder mt-5">Müşteri Kodu</div>
                                    <div class="text-gray-600">{{ $claim->service_claim_address->musteri_kodu }}</div>
                                    <div class="fw-bolder mt-5">Mağaza Takip Kodu</div>
                                    <div class="text-gray-600">{{ $claim->service_claim_address->magaza_takip_kodu }}</div>
                                @endif

                                @if($claim->service_claim_address->teslimEden == 'diger')
                                    <div class="fw-bolder mt-5">Ad Soyad</div>
                                    <div class="text-gray-600">{{ $claim->service_claim_address->diger_ad_soyad }}</div>
                                    <div class="fw-bolder mt-5">Telefon</div>
                                    <div class="text-gray-600">{{ $claim->service_claim_address->diger_telefon }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Container-->
@endsection

@section('extra_content')
    <div class="modal fade" id="modal_onayla" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="modal_onayla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('returns.claim.approve') }}" method="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 text-gray-700">Talep Onayı</h1>
                        </div>
                        <div class="d-flex flex-column mb-5">
                            <textarea class="form-control form-control-solid" rows="4" name="note_onay" placeholder="Onay Notu"></textarea>
                        </div>
                        <div class="mb-13">
                            <div class="text-muted fw-semibold fs-6">
                                Talebi onaylıyorsunuz. Bu işleme devam etmek istediğinizden emin misiniz?
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="hidden" value="{{ $claim->id }}" name="claim_id" id="claim_id">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                            <button type="submit" id="modal_onayla_submit" class="btn btn-primary">
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
        var i = 0;
        let s1= false;
        let s2 = false;
        let s3 = false;
        var element = document.querySelector("#kt_create_ayristirma");
        var stepper = new KTStepper(element);
        stepper.on("kt.stepper.next", function (stepper) {
            if (stepper.getCurrentStepIndex() == 1) {
                $.when(stepper.goNext()).then(function () { s1 = true });
            }
            if (stepper.getCurrentStepIndex() == 2 && s1 == true) {
                $.when(stepper.goNext()).then(function () { s2 = true });
            }
            if (stepper.getCurrentStepIndex() == 3) {
                $('button[data-kt-stepper-action="submit"]').show();
            }
        });
        stepper.on("kt.stepper.previous", function (stepper) {
            stepper.goPrevious();
        });

        $("#satis_tarihi").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),10),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }
        );

        $('#satis_tarihi').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

        $('#satis_tarihi').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        function toastMessage(message, type){
            toastr.options = {
                "closeButton": false,
                "debug": true,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            if (type == "error") {
                toastr.error(message);
            } else if (type == "warning") {
                toastr.warning(message);
            } else {
                toastr.success(message);
            }
        }

        $(document).ready(function(){
            localStorage.clear();

            $(document).on('click', '.btn_remove_part', function(){
                var id = $(this).attr("id");
                $.ajax({
                    type: "GET",
                    url: "{{ route('service.claim.remove_part') }}",
                    data: {id:id},
                    success : function(data){
                        $('#parts_table #row'+id+'').remove();
                        $("#parts_table tbody tr:empty").remove();
                    }
                });
            });

            $(document).on('click', '.btn_remove_expense', function(){
                var id = $(this).attr("id");
                $.ajax({
                    type: "GET",
                    url: "{{ route('service.claim.remove_expense') }}",
                    data: {id:id},
                    success : function(data){
                        $('#expenses_table #row'+id+'').remove();
                        $("#expenses_table tbody tr:empty").remove();
                    }
                });
            });

            if($("#garantili_mi").val() == 'disinda') {
                $("#parca_garantili_mi option[value='1']").attr('disabled','disabled');
            } else {
                $("#parca_garantili_mi option[value='1']").removeAttr('disabled');
            }
        });

        $(function() {

            $('#add_parts').click(function(){
                var part_value = part.options[part.selectedIndex].value;
                var claim_id = '{{ $claim->id }}';
                var claim_detail_id = $('#claim_detail_id').val();
                var garanti = $("#parca_garantili_mi option:selected").val();
                if (garanti != 'Seçiniz') {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('service.claim.add_part') }}",
                        data: {part_value:part_value,claim_id:claim_id,claim_detail_id:claim_detail_id,garanti:garanti},
                        success : function(data){
                            if(data.statu == 'error') {
                                toastMessage(data.message, "error");
                            } else {
                                $('#parts_table').append(data);
                                $('#nasil_cozulecek').prop('selectedIndex',0);
                                $('#nasil_cozeceksin_iris').val("");
                                $('#tamir').prop('selectedIndex',0);
                                $('#claimType').val("");
                            }
                        }
                    });
                } else {
                    toastMessage("Garanti bilgisinin seçilmesi zorunludur.", "error");
                }
            });

            $('#add_expense').click(function(e){
                var tutar = $('#harici_tutar').val();
                var tip = $('#harici_gider').val();
                var tip_text = $( "#harici_gider option:selected" ).text();
                var claim_detail_id = $('#claim_detail_id').val();
                if(tip == '' || tutar == '') {
                    toastMessage("Harici gider tip ve tutar alanlarının doldurulması zorunludur!", "error");
                } else {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('service.claim.add_expense') }}",
                        data: {tutar:tutar,claim_detail_id:claim_detail_id,tip:tip},
                        success : function(response){
                            toastMessage(response.message, "success");
                            $('#expenses_table').append(response.data);
                        }
                    });
                }
            });
        });

        function neresi(){
            var x = document.getElementById("neresi_arizali").value;
            var kat = "{{ $product_iris->iris_kategori }}";

            $.ajax({
                type: 'GET',
                url: "{{ route('service.claim.section_code') }}",
                data: {
                    neden:x,
                    kat:kat
                },
                success: function (data) {
                    document.getElementById('neresi_arizali_iris').innerHTML = data;
                }
            });
        }

        function neden(){
            var x = document.getElementById("neden_arizali").value;
            var kat = "{{ $product_iris->iris_kategori }}";

            $.ajax({
                type: 'GET',
                url: "{{ route('service.claim.defect_code') }}",
                data: {
                    neden:x,
                    kat:kat
                },
                success: function (data) {
                    document.getElementById('neden_arizali_iris').innerHTML = data;
                }
            });
        }

        function nasil(){
            var x = document.getElementById("nasil_cozulecek").value;
            var kat = "{{ $product_iris->iris_kategori }}";
            var rowCount = $('#claimDetailParts tbody tr').length;

            $.ajax({
                type: 'GET',
                url: "{{ route('service.claim.repair_code') }}",
                data: {
                    neden:x,
                    kat:kat
                },
                success: function (data) {
                    document.getElementById('nasil_cozulecek_iris').innerHTML = data;
                    $('#tamir').prop('selectedIndex',0);
                    $('#claimType').val("");
                }
            });
            claim(rowCount, x);
        }

        $('#garantili_mi').on('change', function() {
            garanti = $(this).val();
            if(garanti == 'disinda') {
                $("#parca_garantili_mi option[value='1']").attr('disabled','disabled');
            } else {
                $("#parca_garantili_mi option[value='1']").removeAttr('disabled');
            }
        });

        $('#tamir').on('change', function() {
            var x = document.getElementById("nasil_cozulecek").value;
            var rowCount = $('#claimDetailParts tbody tr').length;
            var tamir = $(this).val();

            if (rowCount > 0 && x != 3 && x != 6 ) {
                switch(tamir) {
                    case 'Bitti':
                        $('#claimType').prop('disabled', false);
                        $('#claimType').find("option").remove();
                        getPartWarrant();
                        break;
                    case 'Bitmedi':
                        $('#claimType').prop('disabled', false);
                        $('#claimType').find("option").remove();
                        $('#claimType').append('<option value="wor">WOR</option>');
                        break;
                    default:
                        $('#claimType').prop('disabled', true);
                        $('#claimType').find("option").remove();
                }
            } else {
                if(rowCount == 0) {
                    claim(rowCount, x);
                } else {
                    $('#claimType').prop('disabled', true);
                    $('#claimType').find("option").remove();
                }
            }
        });

        function getPartWarrant(){
            var claim_detail_id = $('#claim_detail_id').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('service.claim.part_warranty_check') }}",
                data: {
                    claim_detail_id:claim_detail_id
                },
                success: function (data) {
                    if (data == 'true') {
                        $('#claimType').append('<option value="asd">ASD</option>').append('<option value="wos">WOS</option>');
                        $('#claimType option[value="wos"]').attr('disabled','disabled');
                    } else {
                        $('#claimType').append('<option value="asd">ASD</option>').append('<option value="wos" selected>WOS</option>');
                        $('#claimType option[value="wos"]').removeAttr('disabled');
                    }
                }
            });
        }

        function claim(parca, iris) {
            switch (iris) {
                case '1':
                    $('#tamir').prop('disabled', false);
                    $('#claimType').prop('disabled', false);
                    $('#claimType').find("option").remove();
                    $('#claimType').append('<option value="asd">ASD</option>');
                    break;

                case '2':
                    if (parca == 0) {
                        $('#tamir').prop('disabled', false);
                        $('#claimType').find("option").remove();
                        $('#claimType').append('<option value="asd">ASD</option>');
                        $('#claimType').prop('disabled', false);
                    } else {
                        toastMessage("Mekanik bakımda yedek parça seçilemez, parçayı siliniz.", "error");
                        $('#tamir').prop('disabled', true);
                        $('#claimType').prop('disabled', true);
                    }
                    break;

                case '3':
                    if (parca == 0) {
                        $('#tamir').prop('disabled', false);
                        $('#claimType').prop('disabled', false);
                        $('#claimType').find("option").remove();
                        $('#claimType').append('<option value="ase">ASE</option>');
                    } else {
                        toastMessage("Ürün değişimde yedek parça seçilemez, parçayı siliniz.", "error");
                        $('#tamir').prop('disabled', true);
                        $('#claimType').prop('disabled', true);
                    }
                    break;

                case '6':
                    if (parca == 0) {
                        $('#tamir').prop('disabled', false);
                        $('#claimType').prop('disabled', false);
                        $('#claimType').find("option").remove();
                        $('#claimType').append('<option value="ase">RCA</option>');
                    } else {
                        toastMessage("Ürünün mağazadan iade veya değişiminde yedek parça seçilemez, parçayı siliniz.", "error");
                        $('#tamir').prop('disabled', true);
                        $('#claimType').prop('disabled', true);
                    }
                    break;

                default:
                    break;
            }
        }

        $('#ayristirmaFormu').submit(function() {
            if ($("#musteri_nededi option:selected").val() == 0 ||
                $("#neresi_arizali option:selected").val() == 0 ||
                $("#neden_arizalandi option:selected").val() == 0 ||
                $("#nasil_cozulecek option:selected").val() == 0
            ) {
                toastMessage("Iris bilgisinin girilmesi zorunludur.", "error");
                return false;
            }
        });
    </script>
@endsection
