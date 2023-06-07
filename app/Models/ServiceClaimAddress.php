<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceClaimAddress extends Model
{
    use HasFactory;

    protected $table = 'service_claim_addresses';
    protected $guarded = [];
}
