<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'name', 'seats'
    ];

    public function rides()
    {
        return $this->hasMany('App\Ride');
    }
}
