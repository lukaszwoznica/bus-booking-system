<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['name'];

    public function locations()
    {
        return $this->belongsToMany('App\Location')
            ->withPivot('order', 'minutes_from_departure')
            ->withTimestamps();
    }
}
