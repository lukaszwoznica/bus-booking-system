<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('travel_date');
            $table->date('ride_start_date');
            $table->unsignedBigInteger('start_location_id');
            $table->unsignedBigInteger('end_location_id');
            $table->integer('seats');
            $table->enum('status', ['new', 'confirmed', 'rejected', 'cancelled']);
            $table->timestamps();

            $table->foreign('start_location_id')
                ->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('end_location_id')
                ->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
