<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
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

// Insurance
Route::get('car/{id}/insurances', 'InsuranceController@index')->name('insurance.find'); 
Route::get('car/{id}/insurances/create', 'InsuranceController@create')->name('insurance.create'); 
Route::post('car/{id}/insurances/store', 'InsuranceController@store')->name('insurance.store'); 
Route::get('car/{id}/insurances/{insurance_id}/edit', 'InsuranceController@edit')->name('insurance.edit');
Route::put('car/{id}/insurances/{insurance_id}/update', 'InsuranceController@update')->name('insurance.update');
Route::delete('car/{id}/insurances/{insurance_id}/delete', 'InsuranceController@destroy')->name('insurance.destroy'); 

// Maintenance
Route::get('car/{id}/maintenances', 'MaintenanceController@index')->name('maintenance.find'); // id for car's id
Route::get('car/{id}/maintenances/create', 'MaintenanceController@create')->name('maintenance.create'); // id for car's id
Route::post('car/{id}/maintenances/store', 'MaintenanceController@store')->name('maintenance.store'); // id for car's id
Route::get('car/{car_id}/maintenances/{maintenance_id}/edit', 'MaintenanceController@edit')->name('maintenance.edit');
Route::put('car/{car_id}/maintenances/{maintenance_id}/update', 'MaintenanceController@update')->name('maintenance.update');
Route::delete('car/{car_id}/maintenances/{maintenance_id}/delete', 'MaintenanceController@destroy')->name('maintenance.destroy');

// Inspection
Route::get('car/{id}/inspections', 'InspectionController@index')->name('inspection.find'); // id for car's id
Route::get('car/{id}/inspections/create', 'InspectionController@create')->name('inspection.create'); // id for car's id
Route::post('car/{id}/inspections/store', 'InspectionController@store')->name('inspection.store'); // id for car's id
Route::get('car/{car_id}/inspections/{inspection_id}/edit', 'InspectionController@edit')->name('inspection.edit');
Route::put('car/{car_id}/inspections/{inspection_id}/update', 'InspectionController@update')->name('inspection.update');
Route::delete('car/{car_id}/inspections/{inspection_id}/delete', 'InspectionController@destroy')->name('inspection.destroy');


// Route::get('/debug-sentry', function () {
//     throw new Exception('My first Sentry error!');
// });