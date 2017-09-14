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

Route::get('vehicles/', 'VehiclesController@index');
Route::get('vehicles/{vehicle}', 'VehiclesController@display');
Route::post('vehicles', 'VehiclesController@store');
Route::put('vehicles/{vehicle}', 'VehiclesController@update');
Route::delete('vehicles/{vehicle}', 'VehiclesController@delete');

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

Route::get('vehicles/models', 'VehicleModelsController@index');
Route::get('vehicles/models/{model}', 'VehicleModelsController@display');
Route::post('vehicles/models', 'VehicleModelsController@store');
Route::put('vehicles/models/{model}', 'VehicleModelsController@update');
Route::delete('vehicles/models/{model}', 'VehicleModelsController@delete');

Route::get('vehicles/fuels', 'FuelsController@index');
Route::get('vehicles/fuels/{fuel}', 'FuelsController@display');
Route::post('vehicles/fuels', 'FuelsController@store');
Route::put('vehicles/fuels/{fuel}', 'FuelsController@update');
Route::delete('vehicles/fuels/{fuel}', 'FuelsController@delete');

Route::get('vehicles/person_types', 'PersonTypesController@index');
Route::get('vehicles/person_types/{personType}', 'PersonTypesController@display');
Route::post('vehicles/person_types', 'PersonTypesController@store');
Route::put('vehicles/person_types/{personType}', 'PersonTypesController@update');
Route::delete('vehicles/person_types/{personType}', 'PersonTypesController@delete');