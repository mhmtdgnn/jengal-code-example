<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuybackRequest extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    public function brand()
    {
        return $this->hasOne('App\Models\Brand', 'id', 'brand_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function question()
    {
        return $this->hasOne('App\Models\QuestionSet', 'id', 'selected_set');
    }

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id');
    }

    public function town()
    {
        return $this->hasOne('App\Models\Town', 'id', 'town_id');
    }

}
