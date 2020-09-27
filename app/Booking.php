<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
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
