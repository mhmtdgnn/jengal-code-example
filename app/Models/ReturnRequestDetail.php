<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestDetail extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function scopeProductQ($query, $filter_product)
    {
        return $query->whereIn('product_id', $filter_product)->orWhereIn('revizyon_product_id', $filter_product);
    }
}
