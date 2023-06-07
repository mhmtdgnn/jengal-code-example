<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'logs';

    public function kullanici()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
