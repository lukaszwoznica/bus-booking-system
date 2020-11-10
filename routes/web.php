<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/rides', 'RideController@index')->name('rides.index');

Route::get('/my-bookings', 'BookingController@index')->name('bookings.index');
Route::get('/new-booking/{ride}/{startLocation}/{endLocation}/{date}', 'BookingController@create')
    ->name('bookings.create');
Route::post('/bookings', 'BookingController@store')->name('bookings.store');
Route::patch('/bookings/{booking}', 'BookingController@cancel')->name('bookings.cancel');

Route::namespace('Admin')
    ->prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('locations', 'LocationController')->except(['show']);
        Route::resource('buses', 'BusController')->except(['show']);
        Route::resource('routes', 'RouteController');
        Route::resource('rides', 'RideController');
        Route::resource('bookings', 'BookingController')->except(['show', 'create', 'store']);
        Route::resource('users', 'UserController')->except(['show']);;
    });
