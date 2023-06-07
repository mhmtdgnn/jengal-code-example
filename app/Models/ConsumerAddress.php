<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerAddress extends Model
{
    use HasFactory;

    public function consumer()
    {
        return $this->hasOne('App\Models\Consumer', 'consumer_id', 'id');
    }
}
