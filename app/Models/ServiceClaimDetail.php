<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceClaimDetail extends Model
{
    //
    protected $table = 'service_claim_details';
    protected $guarded = [];

    public function product()
    {
        $this->hasOne('App\Models\ServisProduct', 'product_sap_code', 'product_sap_code');
    }

    public function spare_part()
    {
        $this->hasMany('App\Models\ServisPart', 'product_sap_code', 'product_sap_code');
    }
}
