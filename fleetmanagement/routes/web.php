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
Route::get('car/{id}/taxes', 'CarController@showCarTaxes');
Route::get('car/{car_id}/taxes/tax/{id}', 'CarController@showTax');
Route::get('car/{id}/taxes/edit', 'CarController@showEditCarTaxes');
Route::get('car/{id}/taxes/add', 'CarController@showAddTaxForm')->name('add_tax_form');
Route::post('car/{id}/taxes/add', 'CarController@addTax')->name('add_tax');

// CarDriver
Route::resource('cardriver', 'CarDriverController');
