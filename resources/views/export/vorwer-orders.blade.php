<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Sipariş Kodu</th>
            <th>Durum</th>
            <th>Ad Soyad</th>
            <th>Telefon</th>
            <th>Teslimat Adres</th>
            <th>Teslimat Yöntemi</th>
            <th>Kargo Kodu</th>
            <th>Ürün Kodu</th>
            <th>Ürün Adı</th>
            <th>Ürün Fiyatı</th>
            <th>Hediye Ürün</th>
            <th>Sipariş Tarihi</th>
            <th>Kargoya Teslim Tarihi</th>
            <th>Oluşturma Tarihi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $item)
            @foreach($item->detail as $row)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ @$item->siparis_kodu }}</td>
                    <td>{{ $item->statu->title }}</td>
                    <td>
                        @if(!empty($item->teslimat_isim) OR !empty($item->teslimat_soyisim))
                        {{ mb_strtoupper(@$item->teslimat_isim) . ' ' . mb_strtoupper(@$item->teslimat_soyisim) }}
                        @else
                        {{ mb_strtoupper(@$item->consumer->firstName) . ' ' . mb_strtoupper(@$item->consumer->lastName) }}
                        @endif
                    </td>
                    <td>{{ @$item->consumer->phone }}</td>
                    <td>{{ $item->teslimat_adresi1.' '.$item->teslimat_adresi2 }}</td>
                    <td>{{ @$item->transfer_yontemi }}</td>
                    <td>{{ @$item->gonderi_takip_no }}</td>
                    <td>{{ @$row->product_code }}</td>
                    <td>{{ @$row->product_name }}</td>
                    <td>{{ @$row->unit_price }}</td>
                    <td>{{ ($item->hediye_urun == 1) ? 'Evet' : 'Hayır' }}</td>
                    <td>{{ @$item->siparis_tarihi }}</td>
                    <td>{{ @$item->shipped }}</td>
                    <td>{{ @$item->created_at }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>