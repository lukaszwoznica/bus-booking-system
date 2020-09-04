<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideSchedule extends Model
{
    protected $guarded = [];

    public function ride()
    {
        return $this->belongsTo('App\Ride');
    }
}
