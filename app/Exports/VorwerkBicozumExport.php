<?php

namespace App\Exports;

use App\Models\VorwerkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VorwerkBicozumExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, ShouldQueue
{
    use Exportable;

    public function query()
    {
        return VorwerkOrder::query()
            ->with('consumer', 'detail')
            ->where('transfer_yontemi', 'BİÇÖZÜM');
    }

    public function headings(): array
    {
        return [
            '#',
            'Ad Soyad',
            'İl',
            'İlçe',
            'Adres',
            'Telefon',
            'Sipariş Tarihi',
            'Hediye Ürün',
            'Aldığı Ürünler',
            'İmza',
        ];
    }

    public function map($pickups): array
    {
        return [
            $pickups->id,
            $pickups->service->name,
            $pickups->status_name,
            $pickups->consumer->firstName.' '.$pickups->consumer->lastName,
            $pickups->consumer->phone,
            $pickups->created_at,
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'service',
            'status',
            'consumer',
            'phone',
            'date',
        ];
    }
}
