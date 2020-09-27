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

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function schedule()
    {
        return $this->hasOne('App\RideSchedule');
    }

    public function isCyclic()
    {
        return ! isset($this->attributes['ride_date']);
    }
}
