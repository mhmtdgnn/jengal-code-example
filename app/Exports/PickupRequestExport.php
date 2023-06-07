<?php

namespace App\Exports;

use App\Models\PickupRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PickupRequestExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, ShouldQueue
{
    use Exportable;

    public function query()
    {
        return PickupRequest::query()
            ->with('service')
            ->leftJoin('pickup_request_statuses AS prs', 'prs.status_code', '=', 'pickup_requests.status')
            ->orderBy('pickup_requests.created_at', 'DESC');
    }

    public function headings(): array
    {
        return [
            '#',
            'Talep Tipi',
            'Durum',
            'Ad Soyad',
            'Telefon',
            'Tarih',
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
