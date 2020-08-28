<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideInterval extends Model
{
    protected $guarded = [];

    public function ride()
    {
        return $this->belongsTo('App\Ride');
    }
}
