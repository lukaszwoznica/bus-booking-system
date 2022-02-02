<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bus;
use App\Ride;
use App\Route;
use Faker\Generator as Faker;

$factory->define(Ride::class, function (Faker $faker) {
    return [
        'bus_id' => Bus::select('id')->inRandomOrder()->first(),
        'route_id' => Route::select('id')->inRandomOrder()->first(),
        'departure_time' => $faker->time('H:i'),
        'ride_date' => $faker->dateTimeBetween('-6 months', '+6 months'),
        'auto_confirm' => false
    ];
});

$factory->state(Ride::class, 'cyclic', [
    'ride_date' => null
]);
