<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Sipariş Kodu</th>
            <th>Durum</th>
            <th>Ad Soyad</th>
            <th>Telefon</th>
            <th>Teslimat İl</th>
            <th>Teslimat İlçe</th>
            <th>Teslimat Adres</th>
            <th>Teslimat Yöntemi</th>
            <th>Kargo Kodu</th>
            <th>Ürün Adedi</th>
            <th>Ürünler</th>
            <th>Hediye Ürün</th>
            <th>Desi</th>
            <th>Navlun</th>
            <th>Kargo Ücreti</th>
            <th>Sipariş Tarihi</th>
            <th>Kargoya Teslim Tarihi</th>
            <th>Oluşturma Tarihi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $item)
            @php
                $prods = [];
                foreach ($item->detail as $row) {
                    $prods[] = @$row->prod->product_code;
                }
                $products = implode(', ', $prods);
            @endphp
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->siparis_kodu }}</td>
                <td>{{ $item->statu->title }}</td>
                <td>{{ @$item->teslimat_isim.' '.$item->teslimat_soyisim }}</td>
                <td>{{ @$item->consumer->phone }}</td>
                <td>{{ @$item->ups_il->city_name }}</td>
                <td>{{ @$item->ups_ilce->area_name }}</td>
                <td>{{ @$item->teslimat_adresi1.' '.$item->teslimat_adresi2 }}</td>
                <td>{{ $item->transfer_yontemi }}</td>
                <td>{{ $item->gonderi_takip_no }}</td>
                <td>{{ count($item->detail) }}</td>
                <td>{{ $products }}</td>
                <td>{{ ($item->hediye_urun == 1) ? 'Evet' : 'Hayır' }}</td>
                <td>{{ @$item->desi }}</td>
                <td>{{ @$item->freight }}</td>
                <td>{{ @$item->cargoPrice }}</td>
                <td>{{ $item->siparis_tarihi }}</td>
                <td>{{ $item->shipped }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
