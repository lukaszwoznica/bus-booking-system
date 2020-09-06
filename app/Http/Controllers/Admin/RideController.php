<?php

namespace App\Http\Controllers\Admin;

use App\Bus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RideRequest;
use App\Ride;
use App\Route;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::with(['route', 'bus'])->get();

        return view('admin.rides.index', compact('rides'));
    }

    public function create()
    {
        $buses = Bus::all();
        $routes = Route::all();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        return view('admin.rides.create', compact('buses', 'routes', 'days'));
    }

    public function store(RideRequest $request)
    {
        $ride = Ride::create($request->validated());

        if ($request->ride_type == 'cyclic') {
            $requestData = collect($request->validated());
            $rideScheduleData = $requestData
                ->only('start_date', 'end_date')
                ->merge($requestData->get('days'))
                ->toArray();

            $ride->schedule()->create($rideScheduleData);
        }

        session()->flash('status', 'The ride has been successfully created.');

        return redirect()->route('admin.rides.index');
    }

    public function show(Ride $ride)
    {
        //
    }

    public function edit(Ride $ride)
    {
        //
    }

    public function update(Request $request, Ride $ride)
    {
        //
    }

    public function destroy(Ride $ride)
    {
        //
    }
}
