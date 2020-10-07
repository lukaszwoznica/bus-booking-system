<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'ride_id', 'user_id', 'travel_date', 'ride_start_date', 'start_location_id', 'end_location_id', 'seats', 'status'
    ];

    protected $attributes = [
        'status' => BookingStatus::PROCESSING
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
}
