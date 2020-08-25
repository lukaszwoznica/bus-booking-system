<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name'];

    public function routes()
    {
        return $this->belongsToMany('App\Route')
            ->withPivot('order', 'minutes_from_departure')
            ->withTimestamps();
    }
}
