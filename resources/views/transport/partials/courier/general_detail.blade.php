<div class="card card-flush py-4 flex-row-fluid">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h2>Paket Bilgileri</h2>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <div class="table-responsive">
            <div class="border rounded bg-light p-4">
                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-2 min-w-300px">
                    <thead>
                        <tr>
                            <th>Adet</th>
                            <th>Ürün</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $item)
                            <tr>
                                <td>{{ $item->piece }}</td>
                                <td><span class="text-info">{{ $item->product->product_code }}</span> - {{ $item->product->product_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end::Card body-->
</div>