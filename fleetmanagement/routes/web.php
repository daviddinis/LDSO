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
Route::get('car/{car_id}/taxes/tax/{id}', 'TaxController@showTax');
Route::get('car/{id}/taxes/create', 'TaxController@create')->name('tax.create'); 
Route::post('car/{id}/taxes/store', 'TaxController@store')->name('tax.store'); 
Route::get('car/{car_id}/taxes/{tax_id}/edit', 'TaxController@edit')->name('tax.edit');
Route::put('car/{car_id}/taxes/{tax_id}/update', 'TaxController@update')->name('tax.update');
Route::delete('car/{car_id}/taxes/{tax_id}/delete', 'TaxController@destroy')->name('tax.destroy');

// CarDriver
Route::resource('cardriver', 'CarDriverController');
