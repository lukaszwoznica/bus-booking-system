<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['name'];

    public function locations()
    {
        return $this->belongsToMany('App\Location')
            ->withPivot('order', 'minutes_from_departure')
            ->orderBy('location_route.order')
            ->withTimestamps();
    }

    public function rides()
    {
        return $this->hasMany('App\Ride');
    }

    public function getTravelDuration()
    {
        return $this->locations->last()->minutesFromDepartureFormatted();
    }
}
