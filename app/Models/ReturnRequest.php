<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    
    public function consumer()
    {
        return $this->hasOne('App\Models\Consumer', 'id', 'consumer_id');
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'magaza_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\ReturnRequestDetail', 'talep_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\History', 'talep_id', 'id');
    }

    public function scopeReturnId($query, $filter_return_id)
    {
        return $query->where('id', $filter_return_id);
    }

    public function scopeOrderCode($query, $filter_order_code)
    {
        return $query->where('refundOrderNumber', $filter_order_code);
    }
}
