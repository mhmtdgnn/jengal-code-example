<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function logs()
    {
        return $this->hasMany(TransportRequestLog::class, 'activity_id');
    }
    
    public function status()
    {
        return $this->hasOne(TransportRequestStatuses::class, 'status_code', 'status_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'to_city_id');
    }
    
    public function town()
    {
        return $this->hasOne(Town::class, 'id', 'to_town_id');
    }
    
    public function delivery()
    {
        return $this->hasOne(TransportScheduledDelivery::class, 'transport_request_id');
    }

    public function vehicle()
    {
        return $this->hasOneThrough(
            Vehicle::class,                         // model we are trying to get
            TransportScheduledDelivery::class,      // model we have an _id to
            'transport_request_id',                 // WHERE `phone`.`id` = `user`.`phone_id`
            'id',                                   // `key`.`id`
            'id',                                   // local column relation to our through class
            'vehicle_id'                            // `phone`.`key_id`
        );
    }
}