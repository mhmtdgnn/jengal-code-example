<?php

namespace App\Exports;

use App\Models\VorwerkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VorwerkOrderEndOfDayReportExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, ShouldQueue
{
    use Exportable;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function query()
    {
        return VorwerkOrder::query()
            ->with('consumer', 'detail')
            ->whereDate('shipped', $this->filter['date'])
            ->orderBy('id', 'DESC');
    }

    public function headings(): array
    {
        return [
            '#',
            'Ad Soyad',
            'Telefon',
            'Teslimat Adres',
            'Kargo Kodu',
            'Hediye Ürün',
            'Sipariş Tarihi',
            'Kargo Teslim Tarihi',
            'Oluşturma Tarihi'
        ];
    }

    public function map($orders): array
    {
        return [
            $orders->id,
            $orders->teslimat_isim.' '.$orders->teslimat_soyisim,
            @$orders->consumer->phone,
            $orders->teslimat_adresi1.' '.$orders->teslimat_adresi2,
            $orders->gonderi_takip_no,
            ($orders->hediye_urun == 1) ? 'Evet' : 'Hayır',
            $orders->siparis_tarihi,
            $orders->shipped,
            $orders->created_at,
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'consumer',
            'phone',
            'address',
            'cargo_number',
            'gift',
            'order_date',
            'ship_date',
            'created_date',
        ];
    }
}
