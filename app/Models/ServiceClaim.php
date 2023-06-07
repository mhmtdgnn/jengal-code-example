<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceClaim extends Model
{
    //
    protected $table = 'service_claims';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function consumer()
    {
        return $this->hasOne('App\Models\Consumer', 'id', 'consumer_id');
    }

    public function service()
    {
        return $this->hasOne('App\Models\Service', 'id', 'service_id');
    }

    public function service_claim_detail()
    {
        return $this->hasOne('App\Models\ServiceClaimDetail', 'service_claim_id', 'id');
    }

    public function service_claim_central_acceptance()
    {
        return $this->hasOne('App\Models\ServiceClaimCentralAcceptance', 'service_claim_id', 'id');
    }

    public function service_claim_address()
    {
        return $this->hasOne('App\Models\ServiceClaimAddress', 'service_claim_id', 'id');
    }

    public function service_claim_document()
    {
        return $this->hasMany('App\Models\ServiceClaimDocument', 'service_claim_id', 'id');
    }

    public function log()
    {
        return $this->hasMany('App\Models\History', 'talep_id', 'id');
    }
}
