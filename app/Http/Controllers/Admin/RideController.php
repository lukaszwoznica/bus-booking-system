<?php

namespace App\Http\Controllers\Admin;

use App\Bus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ride\RideRequest;
use App\Ride;
use App\Route;

class RideController extends Controller
{
    private $dayNames = [
        'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
    ];

    public function index()
    {
        $rides = Ride::with(['route', 'bus'])->paginate(15);

        return view('admin.rides.index', compact('rides'));
    }

    public function create()
    {
        $buses = Bus::all();
        $routes = Route::all();
        $days = $this->dayNames;

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

        return redirect()->route('admin.rides.index')
            ->withToastSuccess('The ride has been successfully created!');
    }

    public function show(Ride $ride)
    {
        //
    }

    public function edit(Ride $ride)
    {
        $buses = Bus::all();
        $routes = Route::all();
        $days = $this->dayNames;

        return view('admin.rides.edit', compact('ride', 'buses', 'routes', 'days'));
    }

    public function update(RideRequest $request, Ride $ride)
    {
        if ($request->ride_type == 'cyclic') {
            $rideData = array_merge($request->validated(), ['ride_date' => null]);
            $requestData = collect($request->validated());
            $days = collect($this->dayNames)
                ->mapWithKeys(fn($item) => [$item => 0])
                ->replace($requestData->get('days'));

            $rideScheduleData = $requestData
                ->only('start_date', 'end_date')
                ->merge($days)
                ->toArray();

            $ride->update($rideData);
            $ride->schedule()->updateOrCreate(['ride_id' => $ride->id], $rideScheduleData);
        } else {
            $ride->update($request->validated());
            $ride->schedule()->delete();
        }

        return redirect()->route('admin.rides.index')
            ->withToastSuccess('The ride has been successfully updated!');
    }

    public function destroy(Ride $ride)
    {
        try {
            $ride->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.rides.index')
                ->withToastError('An error occurred while deleting the ride.');
        }

        return redirect()->route('admin.rides.index')
            ->withToastSuccess('The ride has been successfully deleted!');
    }
}
