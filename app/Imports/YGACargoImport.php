<?php

namespace App\Imports;

use App\Jobs\YGACargoManagement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class YGACargoImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $data['rows'] = $rows;
        //YGACargoManagement::dispatchNow($data);
        YGACargoManagement::dispatch($data)->onQueue('notification');
    }
}
