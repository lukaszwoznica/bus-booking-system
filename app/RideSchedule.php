<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RideSchedule extends Model
{
    protected $guarded = [];

    protected $dates = [
        'start_date', 'end_date'
    ];

    public function ride()
    {
        return $this->belongsTo('App\Ride');
    }
}
