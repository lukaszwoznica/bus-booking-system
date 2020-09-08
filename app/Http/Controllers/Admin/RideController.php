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
        $rides = Ride::with(['route', 'bus'])->paginate(15);

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
        $buses = Bus::all();
        $routes = Route::all();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        return view('admin.rides.edit', compact('ride', 'buses', 'routes', 'days'));
    }

    public function update(RideRequest $request, Ride $ride)
    {
        if ($request->ride_type == 'cyclic') {
            $rideData = array_merge($request->validated(), ['ride_date' => null]);
            $requestData = collect($request->validated());
            $rideScheduleData = $requestData
                ->only('start_date', 'end_date')
                ->put('ride_id', $ride->id)
                ->merge($requestData->get('days'))
                ->toArray();

            $ride->update($rideData);
            $ride->schedule()->updateOrCreate($rideScheduleData);
        } else {
            $ride->update($request->validated());
            $ride->schedule()->delete();
        }

        session()->flash('status', 'The ride has been successfully updated.');

        return redirect()->route('admin.rides.index');
    }

    public function destroy(Ride $ride)
    {
        try {
            $ride->delete();
            session()->flash('status', 'The ride has been successfully deleted.');
        } catch (\Exception $e) {
            session()->flash('status', 'An error occurred while deleting the ride.');
        }

        return redirect()->route('admin.rides.index');
    }
}
