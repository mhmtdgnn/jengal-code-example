<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ECommerceOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'ecommerce_order_details';

    public function prod()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
