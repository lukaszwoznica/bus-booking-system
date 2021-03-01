<?php


namespace App\Services;


use App\Booking;
use App\BookingStatus;
use App\Location;
use App\Ride;
use App\Route;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RideService
{
    public function getRidesByLocations(Location $startLocation,
                                        Location $endLocation,
                                        string $depDate,
                                        array $routes = null): Collection
    {
        $startLocationId = $startLocation->id;
        $endLocationId = $endLocation->id;
        $dayName = Str::lower(Carbon::parse($depDate)->dayName);
        $dayBefore = Carbon::parse($depDate)->subDay()->toDateString();

        if (!$routes) {
            $routes = $this->getRouteIds($startLocationId, $endLocationId);
        }

        $startLocationRouteSubquery = DB::table('location_route')
            ->where('location_id', $startLocationId);

        $endLocationRouteSubquery = DB::table('location_route')
            ->where('location_id', $endLocationId);

        $calculatedDepartureTime = 'departure_time + INTERVAL (start_location.minutes_from_departure) MINUTE';

        $bookedSeatsSubquery = Booking::selectRaw('SUM(seats)')
            ->join('rides as rides_join', 'ride_id', 'rides_join.id')
            ->join('location_route as booking_start_location', function ($join) {
                $join->on('rides_join.route_id', 'booking_start_location.route_id')
                    ->on('start_location_id', 'booking_start_location.location_id');
            })->join('location_route as booking_end_location', function ($join) {
                $join->on('rides_join.route_id', 'booking_end_location.route_id')
                    ->on('end_location_id', 'booking_end_location.location_id');
            })->where(function (Builder $query) use ($calculatedDepartureTime, $depDate) {
                $query->where(function (Builder $query) use ($calculatedDepartureTime) {
                    $query->whereRaw("$calculatedDepartureTime > '23:59:59'")
                        ->whereRaw('ride_start_date = ?');
                })->orWhere(function (Builder $query) use ($calculatedDepartureTime) {
                    $query->whereRaw("$calculatedDepartureTime <= '23:59:59'")
                        ->whereRaw('ride_start_date = ?');
                });
            })->whereColumn([
                ['ride_id', '=', 'rides.id'],
                ['booking_start_location.order', '<', 'end_location.order'],
                ['booking_end_location.order', '>', 'start_location.order']
            ])->whereRaw('status = ?')
            ->toSql();

        $select = "rides.*, $calculatedDepartureTime as start_location_dep_time, ($bookedSeatsSubquery) as booked_seats";

        $ridesQuery = Ride::selectRaw($select, [$dayBefore, $depDate, BookingStatus::CONFIRMED])
            ->joinSub($startLocationRouteSubquery, 'start_location', function ($join) {
                $join->on('rides.route_id', 'start_location.route_id');
            })->joinSub($endLocationRouteSubquery, 'end_location', function ($join) {
                $join->on('rides.route_id', 'end_location.route_id');
            })->whereHas('route', function (Builder $query) use ($routes) {
                $query->whereIn('id', $routes);
            })->where(function (Builder $query) use ($dayName, $depDate, $calculatedDepartureTime, $dayBefore) {
                $query->whereHas('schedule', function (Builder $query) use ($dayName, $depDate, $calculatedDepartureTime, $dayBefore) {
                    $query->where(function (Builder $query) use ($dayName, $depDate, $calculatedDepartureTime, $dayBefore) {
                        $query->where(function (Builder $query) use ($dayName, $depDate, $calculatedDepartureTime, $dayBefore) {
                            $query->where($dayName, true)
                                ->where('start_date', '<=', $depDate)
                                ->whereRaw("$calculatedDepartureTime <= '23:59:59'");
                        })->orWhere(function (Builder $query) use ($dayBefore, $calculatedDepartureTime) {
                            $dayNameBefore = Str::lower(Carbon::parse($dayBefore)->dayName);
                            $query->where($dayNameBefore, true)
                                ->where('start_date', '<=', $dayBefore)
                                ->whereRaw("$calculatedDepartureTime > '23:59:59'");
                        });
                    })->where(function (Builder $query) use ($depDate) {
                        $query->where('end_date', '>=', $depDate)
                            ->orWhereNull('end_date');
                    });
                })->orWhere(function (Builder $query) use ($depDate, $calculatedDepartureTime, $dayBefore) {
                    $query->where('ride_date', $depDate)
                        ->orWhere(function (Builder $query) use ($dayBefore, $calculatedDepartureTime) {
                            $query->where('ride_date', $dayBefore)
                                ->whereRaw("$calculatedDepartureTime > '23:59:59'");
                        });
                });
            })->with('route.locations', 'bus');

        if (Carbon::parse($depDate)->isToday()) {
            $ridesQuery->whereRaw("$calculatedDepartureTime BETWEEN ? AND ?", [
                Carbon::now()->toTimeString(),
                '23:59:59'
            ]);
        }

        $rides = $ridesQuery->get();
        $rides = $rides->each(function ($ride) {
            $hours = substr($ride->start_location_dep_time, 0, 2);
            $minutes = substr($ride->start_location_dep_time, 3, 2);
            $time = (new DateTime())->setTime($hours, $minutes);
            $ride->start_location_dep_time = $time->format('H:i:s');
        });

        return $rides->sortBy('start_location_dep_time');
    }


    private function getRouteIds(int $startLocationId, int $endLocationId): array
    {
        return Route::whereHas('locations', function (Builder $query) use ($startLocationId) {
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
    }
}
