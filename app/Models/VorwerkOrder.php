<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VorwerkOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany('App\Models\VorwerkOrderDetail', 'order_id', 'id');
    }

    public function consumer()
    {
        return $this->hasOne('App\Models\Consumer', 'id', 'consumer_id');
    }

    public function ups_il()
    {
        return $this->hasOne('App\Models\UPSDistrict', 'city_id', 'teslimat_il_ups');
    }

    public function ups_ilce()
    {
        return $this->hasOne('App\Models\UPSDistrict', 'area_id', 'teslimat_ilce_ups');
    }

    public function statu()
    {
        return $this->hasOne('App\Models\VorwerkOrderStatus', 'id', 'durum');
    }

    public function cargoCodes()
    {
        return $this->hasMany('App\Models\VorwerkOrderCargoCode', 'order_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\VorwerkOrderLog', 'order_id', 'id');
    }

    public function scopeDestinationContactFirstName($query, $filter_consumer_firstname)
    {
        return $query->orWhere('teslimat_isim', 'LIKE', '%'.$filter_consumer_firstname.'%');
    }

    public function scopeDestinationContactLastName($query, $filter_consumer_lastname)
    {
        return $query->orWhere('teslimat_soyisim', 'LIKE', '%'.$filter_consumer_lastname.'%');
    }

    public function scopeOrderCode($query, $filter_order_code)
    {
        return $query->where('siparis_kodu', 'LIKE', '%'.$filter_order_code.'%');
    }
    
    public function scopeStatu($query, $filter_statu)
    {
        return $query->whereIn('durum', $filter_statu);
    }

    public function scopeTransferMethod($query, $filter_transfer_method)
    {
        return $query->where('transfer_yontemi', $filter_transfer_method);
    }
}
