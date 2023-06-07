<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuybackRequestLog extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'buyback_request_logs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $updated_at = false;

    protected $fillable = ['id', 'buyback_request_id', 'status_id', 'comment', 'created_at'];

    public function status()
    {
        return $this->hasOne('App\Models\BuybackRequestStatus', 'id', 'status_id');
    }
}
