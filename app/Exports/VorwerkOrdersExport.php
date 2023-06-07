<?php

namespace App\Exports;

use App\Models\VorwerkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VorwerkOrdersExport implements FromView, ShouldAutoSize, ShouldQueue
{

    use Exportable;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function view(): View
    {
        if (isset($this->filter['start_date'])) {
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
            ->whereDate('created_at', '>=', $this->filter['start_date']);
        }

        if (isset($this->filter['end_date'])) {
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
            ->whereDate('created_at', '<=', $this->filter['end_date']);
        }

        if (isset($this->filter['start_date']) and isset($this->filter['end_date'])) {
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
            ->whereDate('created_at', '>=', $this->filter['start_date'])
            ->whereDate('created_at', '<=', $this->filter['end_date']);
        }

        if (empty($this->filter['start_date']) and empty($this->filter['end_date'])) {
            $orders = VorwerkOrder::with(
                [
                    'detail' => function ($q) {
                        $q->select('vorwerk_order_details.*', 'p.product_code', 'p.product_name');
                        $q->leftJoin('products as p', 'vorwerk_order_details.product_id', '=', 'p.id');
                    },
                    'consumer',
                    'statu'
                ]
            );
        }

        $orders = $orders->orderBy('id', 'DESC')->get();

        return view(
            'export.vorwer-orders', ['orders' => $orders]
        );
    }
}
