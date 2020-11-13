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

// Car
Route::resource('car', 'CarController');

// Tax
Route::get('car/{id}/taxes', 'TaxController@index')->name('tax.find');
Route::get('car/{id}/maintenances/create', 'TaxController@create')->name('tax.create'); 
Route::post('car/{id}/maintenances/store', 'TaxController@store')->name('tax.store'); 

// CarDriver
Route::resource('cardriver', 'CarDriverController');
