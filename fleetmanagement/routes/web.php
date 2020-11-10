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

Route::get('/', 'Auth\LoginController@home');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Driver
Route::resource('driver', 'DriverController');

// Car Alerts
Route::get('car/{id}/settings', 'CarController@showManageAlerts')->name('alerts');
Route::post('car/{id}/settings', 'CarController@editAlerts')->name('editAlerts');

// Car
Route::resource('car', 'CarController');

// CarDriver
Route::resource('cardriver', 'CarDriverController');

// Maintenance
Route::get('car/{id}/maintenances', 'MaintenanceController@index')->name('maintenance.find'); // id for car's id and id2 for maintenance's id

// Route::get('/debug-sentry', function () {
//     throw new Exception('My first Sentry error!');
// });