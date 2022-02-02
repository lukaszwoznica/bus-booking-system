<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Bus;
use Faker\Generator as Faker;

$factory->define(Bus::class, function (Faker $faker) {
    return [
        'name' => 'Bus ' . $faker->unique()->randomNumber(),
        'seats' => $faker->numberBetween(20, 60)
    ];
});
