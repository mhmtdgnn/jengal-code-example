<?php

namespace App\Models\YeniGibiAl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $connection = "yenigibial_test";
    protected $table = "oc_order";

    protected $primaryKey = 'order_id';
    const UPDATED_AT = 'date_modified';

    protected  $fillable = ['order_status_id', 'kargo_firmasi', 'kargo_kodu', 'ettn_no', 'irsaliye_no'];
}
