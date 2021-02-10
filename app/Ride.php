<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        return !isset($this->attributes['ride_date']);
    }

    public function scopeActive(Builder $query)
    {
        $query->where('ride_date', '>', Carbon::today())
            ->orWhere(function (Builder $query) {
                $query->where('ride_date', Carbon::today())
                    ->where('departure_time', '>', Carbon::now()->toTimeString());
            })->orWhereHas('schedule', function (Builder $query) {
                $query->where('end_date', '>', Carbon::today())
                    ->orWhere(function (Builder $query) {
                        $query->where('end_date', Carbon::today())
                            ->where('departure_time', '>', Carbon::now()->toTimeString());
                    })->orWhereNull('end_date');
            });
    }
}
