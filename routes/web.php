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

Route::name('profile.')->group(function () {
    Route::get('/profile', 'ProfileController@edit')->name('edit');
    Route::patch('/profile/{user}', 'ProfileController@update')->name('update');
    Route::patch('/profile/{user}/password', 'ProfileController@updatePassword')->name('update-password');
});

Route::name('bookings.')->group(function () {
    Route::get('/my-bookings', 'BookingController@index')->name('index');
    Route::get('/new-booking/{ride}{startLocation}/{endLocation}/{date}', 'BookingController@create')->name('create');
    Route::get('booking/{booking}', 'BookingController@show')->name('show');
    Route::post('/bookings', 'BookingController@store')->name('store');
    Route::patch('/bookings/{booking}', 'BookingController@cancel')->name('cancel');
});

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
