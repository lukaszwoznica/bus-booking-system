<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
        'bus_id', 'route_id', 'departure_time', 'ride_date'
    ];

    protected $dates = [
        'departure_time', 'ride_date'
    ];

    public function bus()
    {
        return $this->belongsTo('App\Bus');
    }

    public function route()
    {
        return $this->belongsTo('App\Route');
    }

    public function schedule()
    {
        return $this->hasOne('App\RideSchedule');
    }
}
