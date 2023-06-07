<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestDetailPart extends Model
{
    use HasFactory;

    protected $table = 'return_request_detail_parts';

    public function parts_detail()
    {
        return $this->hasOne('App\Models\Part', 'parts_sap_code', 'parts_sap_code');
    }
}
