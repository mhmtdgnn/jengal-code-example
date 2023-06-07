<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function documents()
    {
        return $this->hasMany('App\Models\ServiceDocument', 'service_id', 'id');
    }

    public function banks()
    {
        return $this->hasMany('App\Models\ServiceBank', 'service_id', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'servis_id', 'id');
    }

    public function authorizedPerson()
    {
        return $this->hasOne('App\Models\User', 'id', 'yetkili_kisi');
    }

    public function fieldManager()
    {
        return $this->hasOne('App\Models\User', 'id', 'servis_saha_sorumlusu');
    }

    public function operationsManager()
    {
        return $this->hasOne('App\Models\User', 'id', 'operasyon_muduru');
    }

    public function serviceManager()
    {
        return $this->hasOne('App\Models\User', 'id', 'servis_muduru');
    }
}
