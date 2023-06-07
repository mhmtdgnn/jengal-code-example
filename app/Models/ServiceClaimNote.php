<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceClaimNote extends Model
{
    protected $table = 'service_claim_notes';
    
    public function kullanici()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
