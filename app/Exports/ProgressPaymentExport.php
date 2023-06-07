<?php

namespace App\Exports;

use App\Models\ReturnRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProgressPaymentExport implements FromView
{

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        $returns = ReturnRequest::with(
            [
                'details' => function ($q) {
                    $q->select('return_request_details.*', 'p.product_sap_code', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'return_request_details.product_id', '=', 'p.id');
                },
                'store'
            ]
        )
        ->where('atolye_hakedis', 2)
        ->where('faturalanma_tarihi', $this->date)
        ->orderby('id', 'desc')
        ->get();

        return view('export.progress-payment-export',
            [
                'returns' => $returns
            ]
        );
    }
}
