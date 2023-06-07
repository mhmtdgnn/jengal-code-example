<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function consumer()
    {
        return $this->hasOne('App\Models\Consumer', 'id', 'consumer_id');
    }
    
    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'store_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\PickupRequestDetail', 'pickup_request_id', 'id');
    }

    public function consumerAddress()
    {
        return $this->hasOne('App\Models\ConsumerAddress', 'id', 'address_id');
    }

    public function service()
    {
        return $this->hasOne('App\Models\PickupRequestType', 'id', 'type');
    }

    public function statusInfo()
    {
        return $this->hasOne('App\Models\PickupRequestStatus', 'status_code', 'status');
    }

    public function scopeRequestCode($query, $filter_request_code)
    {
        return $query->where('id', $filter_request_code);
    }

    public function scopeRequestType($query, $filter_request_type)
    {
        return $query->where('type', $filter_request_type);
    }
    
    public function scopeStatus($query, $filter_status)
    {
        return $query->where('status', $filter_status);
    }
}
