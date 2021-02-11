<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Location\LocationRequest;
use App\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::paginate(15);

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(LocationRequest $request)
    {
        Location::create($request->validated());

        return redirect()->route('admin.locations.index')
            ->withToastSuccess('The location has been successfully created!');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return redirect()->route('admin.locations.index')
            ->withToastSuccess('The location has been successfully updated!');
    }

    public function destroy(Location $location)
    {
        try {
            $location->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.locations.index')
                ->withToastError('An error occurred while deleting the location.');
        }

        return redirect()->route('admin.locations.index')
            ->withToastSuccess('The location has been successfully deleted!');
    }
}
