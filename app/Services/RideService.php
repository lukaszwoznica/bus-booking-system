<?php


namespace App\Services;


use App\Location;
use App\Ride;
use App\Route;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RideService
{
    public function getRidesByLocations(Location $startLocation, Location $endLocation, string $departureDate): Collection
    {
        $startLocationId = $startLocation->id;
        $endLocationId = $endLocation->id;
        $dayName = Str::lower(Carbon::parse($departureDate)->dayName);

        $routes = Route::whereHas('locations', function (Builder $query) use ($startLocationId) {
            $query->where('id', $startLocationId);
        })->whereHas('locations', function (Builder $query) use ($startLocationId, $endLocationId) {
            $query->where('id', $endLocationId)
                ->where('order', '>', function (QueryBuilder $query) use ($startLocationId) {
                    $query->select('order')
                        ->from('location_route')
                        ->where('location_id', $startLocationId)
                        ->whereColumn('route_id', 'routes.id');
                });
        })
            ->get()
            ->pluck('id')
            ->toArray();

        $departureTimeSubquery = DB::table('location_route')
            ->select('minutes_from_departure')
            ->whereColumn('route_id', 'rides.route_id')
            ->whereRaw('location_id = ?')
            ->toSql();

        $departureTimeSubquery = "(departure_time + INTERVAL ($departureTimeSubquery) MINUTE)";

        $ridesQuery = Ride::whereHas('route', function (Builder $query) use ($routes) {
            $query->whereIn('id', $routes);
        })->where(function (Builder $query) use ($dayName, $departureDate) {
            $query->whereHas('schedule', function (Builder $query) use ($dayName, $departureDate) {
                $query->where($dayName, true)
                    ->where('start_date', '<=', $departureDate)
                    ->where(function (Builder $query) use ($departureDate) {
                        $query->where('end_date', '>=', $departureDate)
                            ->orWhereNull('end_date');
                    });
            })->orWhere('ride_date', $departureDate);
        })->with('route.locations');

        if (Carbon::parse($departureDate)->isToday()) {
            $ridesQuery->whereRaw("$departureTimeSubquery BETWEEN ? AND ?", [
                $startLocationId,
                Carbon::now()->toTimeString(),
                '23:59:59'
            ]);
        }

        return $ridesQuery->get();
    }
}
