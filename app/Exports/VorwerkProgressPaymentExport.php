<?php

namespace App\Exports;

use App\Models\VorwerkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VorwerkProgressPaymentExport implements FromView, ShouldAutoSize, ShouldQueue
{
    use Exportable;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        $orders = VorwerkOrder::with(
                [
                    'detail' => function ($q) {
                        $q->select('vorwerk_order_details.*', 'p.product_code', 'p.product_name');
                        $q->leftJoin('products as p', 'vorwerk_order_details.product_id', '=', 'p.id');
                    },
                    'consumer',
                    'statu'
                ]
            )
            ->where('faturalanma_tarihi', $this->date)
            ->orderBy('id', 'DESC')
            ->get();

        return view('export.vorwerk-progress-payment-export',
            [
                'orders' => $orders
            ]
        );
    }
}
