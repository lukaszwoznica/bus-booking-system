<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Location;
use Illuminate\Http\Request;

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

        session()->flash('status', 'The location has been successfully created.');

        return redirect()->route('admin.locations.index');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        session()->flash('status', 'The location has been successfully updated.');

        return redirect()->route('admin.locations.index');
    }

    public function destroy(Location $location)
    {
        try {
            $location->delete();
            session()->flash('status', 'The location has been successfully deleted.');
        } catch (\Exception $e) {
            session()->flash('status', 'An error occurred while deleting the locality.');
        }

        return redirect()->route('admin.locations.index');
    }
}
