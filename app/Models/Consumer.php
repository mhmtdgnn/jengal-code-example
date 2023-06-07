<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Consumer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guid',
        'company_id',
        'firstName',
        'lastName',
        'email',
        'phone',
    ];

    public function scopeConsumerFirstName($query, $filter_consumer_firstname)
    {
        return $query->where('firstName', 'LIKE', '%'.$filter_consumer_firstname.'%');
    }

    public function scopeConsumerLastName($query, $filter_consumer_lastname)
    {
        return $query->where('lastName', 'LIKE', '%'.$filter_consumer_lastname.'%');
    }
    
    public function scopeConsumerPhone($query, $filter_consumer_phone)
    {
        return $query->where('phone', 'LIKE', '%'. preg_replace('/[^0-9]/', '', $filter_consumer_phone).'%');
    }
}
