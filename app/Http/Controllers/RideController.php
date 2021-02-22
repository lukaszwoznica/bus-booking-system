<?php

namespace App\Http\Controllers;


use App\Http\Requests\Ride\SearchRideRequest;
use App\Location;
use App\Services\RideService;
use Carbon\Carbon;


class RideController extends Controller
{
    private RideService $ridesService;

    public function __construct(RideService $rideService)
    {
        $this->ridesService = $rideService;
    }

    public function index(SearchRideRequest $request)
    {
        $startLocation = Location::where('name', $request->start_location)->with('routes')->first();
        $endLocation = Location::where('name', $request->end_location)->with('routes')->first();
        $departureDate = $request->date;

        if (! $startLocation) {
            $errors['start_location'] = 'The location with the given name does not exist.';
        }
        if (! $endLocation) {
            $errors['end_location'] = 'The location with the given name does not exist.';
        }

        if (isset($errors)) {
            return redirect()->route('home')
                ->withErrors($errors)
                ->withInput($request->input());
        }

        $rides = $this->ridesService->getRidesByLocations($startLocation, $endLocation, $departureDate);
        $departureDate = Carbon::parse($departureDate);

        return view('rides.index', compact('rides', 'startLocation', 'endLocation', 'departureDate'));
    }
}
