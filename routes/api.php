<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('vehicles/types', 'VehicleTypesController@index');
Route::get('vehicles/types/{vehicleType}', 'VehicleTypesController@display');
Route::post('vehicles/types', 'VehicleTypesController@store');
Route::put('vehicles/types/{vehicleType}', 'VehicleTypesController@update');
Route::delete('vehicles/types/{vehicleType}', 'VehicleTypesController@delete');

Route::get('vehicles/brands', 'VehicleBrandsController@index');
Route::get('vehicles/brands/{brand}', 'VehicleBrandsController@display');
Route::post('vehicles/brands', 'VehicleBrandsController@store');
Route::put('vehicles/brands/{brand}', 'VehicleBrandsController@update');
Route::delete('vehicles/brands/{brand}', 'VehicleBrandsController@delete');