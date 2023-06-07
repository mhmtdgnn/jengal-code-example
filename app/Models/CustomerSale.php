<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSale extends Model
{
    use HasFactory;

    protected $table = 'customer_sales';
    protected $fillable = [
        'tarih',
        'vkn',
        'malzeme',
        'sales',
        'birim_fiyat',
        'belge',
        'active',
        'fatura_tipi'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'tarih'
    ];

    protected $casts = [
        'tarih' => 'date'
    ];
}
