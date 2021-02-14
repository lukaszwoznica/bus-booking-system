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

    public function isActive(): bool
    {
        return ($this->ride_date > Carbon::today()
            || ($this->ride_date == Carbon::today() && $this->departure_time > Carbon::now())
            || ($this->isCyclic() && (
                    optional($this->schedule)->end_date > Carbon::today()
                    || is_null(optional($this->schedule)->end_date)
                    || (optional($this->schedule)->end_date == Carbon::today() && $this->departure_time > Carbon::now())
                )
            ));
    }

    public function getRunningDaysAttribute(): array
    {
        return collect(Carbon::getDays())
            ->reject(fn($day) => $this->schedule->attributes[strtolower($day)] == 0)
            ->toArray();
    }

    /**
     * Returns arrival time to the provided location.
     * If location not specified function returns arrival time to last location in the route.
     *
     * @param int|null $locationId
     * @return string
     */
    public function getArrivalTimeToLocation(int $locationId = null): string
    {
        $location = is_null($locationId)
            ? $this->route->locations->last()
            : $this->route->locations->firstWhere('id', $locationId);

        return $this->departure_time
            ->addMinutes($location->pivot->minutes_from_departure)
            ->format('H:i');
    }
}
