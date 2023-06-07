<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Talep ID</th>
            <th>Mağaza</th>
            <th>Müşteri Kodu</th>
            <th>Vergi Numarası</th>
            <th>Ürün Adı</th>
            <th>Ürün SAP Kodu</th>
            <th>Yedek P. Adet</th>
            <th>Yedek Parçalar</th>
            <th>İşçilik Ücreti</th>
            <th>Ayrıştırma Kategori</th>
        </tr>
    </thead>
    <tbody>
        @foreach($returns as $item)
            @foreach($item->details as $row)
                @php
                    $parts = \App\Models\ReturnRequestDetailPart::where('return_detail_id', $row->id)->pluck('parts_sap_code');
                @endphp
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->talep_id }}</td>
                    <td>{{ $item->store->name }}</td>
                    <td>{{ $item->store->musteri_kodu }}</td>
                    <td>{{ $item->store->vergi_no }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->product_sap_code }}</td>
                    <td>{{ count($parts) }}</td>
                    <td>{{ $parts }}</td>
                    <td>{{ $row->iscilik_ucreti / 100 }}</td>
                    <td>T{{ @$row->ayristirma_id }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>