@php
    $faturaTarih = strtotime($billing_information->tarih);
    $talepTarih = strtotime($return->created_at);
    $difference = date_diff($billing_information->tarih, $return->created_at);
@endphp
<div class="card">
    <div class="card-body">
        <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
            <thead>
                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th>#</th>
                    <th>Tarih</th>
                    <th>VKN</th>
                    <th>Malzeme</th>
                    <th>Birim Fiyat</th>
                    <th>Belge</th>
                    <th>Geçen Süre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $billing_information->id }}</td>
                    <td>{{ $billing_information->tarih->format('Y-m-d') }}</td>
                    <td>{{ $billing_information->vkn }}</td>
                    <td>{{ $billing_information->malzeme }}</td>
                    <td>{{ $billing_information->birim_fiyat }}</td>
                    <td>{{ $billing_information->belge }}</td>
                    <td>{{ $difference->y }} yıl {{ $difference->m }} ay </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>