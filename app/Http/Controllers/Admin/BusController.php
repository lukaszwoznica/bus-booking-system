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

        return redirect()->route('admin.buses.index')
            ->withToastSuccess('The bus has been successfully created!');
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(BusRequest $request, Bus $bus)
    {
        $bus->update($request->validated());

        return redirect()->route('admin.buses.index')
            ->withToastSuccess('The bus has been successfully updated!');
    }

    public function destroy(Bus $bus)
    {
        try {
            $bus->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.buses.index')
                ->withToastError('An error occurred while deleting the bus.');
        }

        return redirect()->route('admin.buses.index')
            ->withToastSuccess('The bus has been successfully deleted!');
    }
}
