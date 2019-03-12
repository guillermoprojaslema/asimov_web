<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('appointments', 'AppointmentsController@index')->name('appointments.index');
Route::get('appointments/create/{appointment}', 'AppointmentsController@create')->name('appointments.create');
Route::post('appointments', 'AppointmentsController@store')->name('appointments.store');
Route::get('appointments/{appointment}', 'AppointmentsController@show')->name('appointments.show');
Route::get('appointments/{appointment}/edit', 'AppointmentsController@edit')->name('appointments.edit');
Route::patch('appointments/{appointment}', 'AppointmentsController@update')->name('appointments.update');
Route::delete('appointments/{appointment}', 'AppointmentsController@destroy')->name('appointments.destroy');
