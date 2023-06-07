<?php

namespace App\Imports;

use App\Jobs\ThermomixOrderManagement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class ThermomixOrderImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $data['rows'] = $rows;
        //ThermomixOrderManagement::dispatchNow($data);
        //ThermomixOrderManagement::dispatch($data)->onQueue('notification');

        $orders = [];

        foreach ($data['rows'] as $item) {
            if (!isset($orders[$item['customer_order_number']])) {
                $orders[$item['customer_order_number']] = [];
            }
            
            $orders[$item['customer_order_number']][] = $item;
        }
        ksort($orders);

        if (!empty($item)) {
            $row['i'] = 0;
            $row['giftItem'] = 0;
            $row['user_id'] = Auth::user()->id;
            foreach ($orders as $key => $order) {
                $row['order'] = $order;
                ThermomixOrderManagement::dispatchNow($row);
            }
        }
    }
}
