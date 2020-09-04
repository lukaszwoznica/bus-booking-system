<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
        'bus_id', 'route_id', 'departure_time', 'ride_date'
    ];

    public function interval()
    {
        return $this->hasOne('App\RideSchedule');
    }
}
