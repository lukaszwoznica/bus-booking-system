<?php

namespace App\DataTables\Scopes\Rides;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Contracts\DataTableScope;

class InactiveRides implements DataTableScope
{
    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return $query->where('ride_date', '<', Carbon::today())
            ->orWhere(function (Builder $query) {
                $query->where('ride_date', Carbon::today())
                    ->where('departure_time', '<=', Carbon::now()->toTimeString());
            })->orWhereHas('schedule', function (Builder $query) {
                $query->where('end_date', '<', Carbon::today())
                    ->orWhere(function (Builder $query) {
                        $query->where('end_date', Carbon::today())
                            ->where('departure_time', '<=', Carbon::now()->toTimeString());
                    });
            });
    }
}
