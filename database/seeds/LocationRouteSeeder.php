<?php

use App\Location;
use App\Route;
use Illuminate\Database\Seeder;

class LocationRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = factory(Location::class, 150)->create();

        for ($i = 0; $i < 100; $i++) {
            $routeLocations = $locations->random(rand(10, 35))->shuffle();
            $routeName = $routeLocations->first()->name . ' - ' . $routeLocations->last()->name;
            $pivotTableData = $routeLocations->mapWithKeys(function ($location, $index) {
                return [
                    $location->id => [
                        'minutes_from_departure' => $index == 0 ? 0 : $index * 20 + rand(0, 10),
                        'order' => $index
                    ]
                ];
            })->toArray();

            factory(Route::class)->create([
                'name' => $routeName
            ])->locations()->attach($pivotTableData);
        }
    }
}
