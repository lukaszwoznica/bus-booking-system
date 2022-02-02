<?php

use App\Ride;
use App\RideSchedule;
use Illuminate\Database\Seeder;

class RideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Single rides
        factory(Ride::class, 100)->create();

        // Cyclic rides with schedules
        factory(RideSchedule::class, 300)->create();
    }
}
