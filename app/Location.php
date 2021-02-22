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

    public function minutesFromDepartureFormatted()
    {
        $minutes = $this->pivot->minutes_from_departure;

        if (floor($minutes / 60) > 0) {
            return sprintf('%dh %02dmin', floor($minutes / 60), $minutes % 60);
        }

        return sprintf('%2dmin', floor($minutes % 60));
    }

    public function getOrderInRoute(int $routeId): int
    {
        return $this->routes->find($routeId)->pivot->order;
    }
}
