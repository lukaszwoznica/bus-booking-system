<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Bus;
use App\Http\Requests\Admin\Bus\BusRequest;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::paginate(15);

        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(BusRequest $request)
    {
        Bus::create($request->validated());

        session()->flash('status', 'The bus has been successfully created.');

        return redirect()->route('admin.buses.index');
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(BusRequest $request, Bus $bus)
    {
        $bus->update($request->validated());

        session()->flash('status', 'The bus has been successfully updated.');

        return redirect()->route('admin.buses.index');
    }

    public function destroy(Bus $bus)
    {
        try {
            $bus->delete();
            session()->flash('status', 'The bus has been successfully deleted.');
        } catch (\Exception $e) {
            session()->flash('status', 'An error occurred while deleting the bus.');
        }

        return redirect()->route('admin.buses.index');
    }
}
