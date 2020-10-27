<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'ride_id', 'user_id', 'travel_date', 'ride_start_date', 'start_location_id', 'end_location_id', 'seats', 'status'
    ];

    protected $attributes = [
        'status' => BookingStatus::PROCESSING
    ];

    protected $dates = [
        'travel_date', 'ride_start_date'
    ];

    public function ride()
    {
        return $this->belongsTo('App\Ride');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function startLocation()
    {
        return $this->belongsTo('App\Location', 'start_location_id');
    }

    public function endLocation()
    {
        return $this->belongsTo('App\Location', 'end_location_id');
    }

    public function canBeCancelled(): bool
    {
        $rideDepartureTime = $this->ride->departure_time;
        $startLocationMinutesFromDeparture = $this->ride->route->locations
            ->find($this->startLocation->id)
            ->pivot->minutes_from_departure;
        $bookingDeparture = $this->ride_start_date
            ->setTimeFrom($rideDepartureTime)
            ->addMinutes($startLocationMinutesFromDeparture);

        return Carbon::now()->diffInHours($bookingDeparture, false) >= 2
            && ($this->status != BookingStatus::CANCELLED && $this->status != BookingStatus::REJECTED);
    }
}
