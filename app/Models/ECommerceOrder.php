<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ECommerceOrder extends Model
{
    use HasFactory;

    protected $table = 'ecommerce_orders';

    public function detail()
    {
        return $this->hasMany('App\Models\ECommerceOrderDetail', 'order_id', 'id');
    }
}
