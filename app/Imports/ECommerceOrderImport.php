<?php

namespace App\Imports;

use App\Jobs\ECommerceOrderManagement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class ECommerceOrderImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $data['rows'] = $rows;

        $orders = [];

        foreach ($data['rows'] as $item) {
            if (!isset($orders[$item['siparis_no']])) {
                $orders[$item['siparis_no']] = [];
            }

            $orders[$item['siparis_no']][] = $item;
        }
        ksort($orders);

        if (!empty($item)) {
            $row['i'] = 0;
            $row['user_id'] = Auth::user()->id;
            foreach ($orders as $key => $order) {
                $row['order'] = $order;
                $row['method'] = 'import';
                ECommerceOrderManagement::dispatchNow($row);
            }
        }
    }
}
