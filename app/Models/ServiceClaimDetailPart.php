<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceClaimDetailPart extends Model
{
    use HasFactory;

    public function parts_detail()
    {
        return $this->hasOne('App\Models\Part', 'parts_sap_code', 'parts_sap_code');
    }
}
