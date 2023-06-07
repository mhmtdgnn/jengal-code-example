<?php

namespace App\Models\YeniGibiAl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;
    protected $connection = "yenigibial_test";
    protected $table = "oc_order_history";

    protected $primaryKey = 'order_history_id';
    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_added';

    protected  $fillable = ['order_id', 'order_status_id', 'notify', 'comment'];
}
