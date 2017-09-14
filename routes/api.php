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

Route::get('types', 'VehicleTypesController@index');
Route::get('types/{vehicleType}', 'VehicleTypesController@display');
Route::post('types', 'VehicleTypesController@store');
Route::put('types/{vehicleType}', 'VehicleTypesController@update');
Route::delete('types/{vehicleType}', 'VehicleTypesController@delete');

Route::get('brands', 'VehicleBrandsController@index');
Route::get('brands/{brand}', 'VehicleBrandsController@display');
Route::post('brands', 'VehicleBrandsController@store');
Route::put('brands/{brand}', 'VehicleBrandsController@update');
Route::delete('brands/{brand}', 'VehicleBrandsController@delete');

Route::get('models', 'VehicleModelsController@index');
Route::get('models/{model}', 'VehicleModelsController@display');
Route::post('models', 'VehicleModelsController@store');
Route::put('models/{model}', 'VehicleModelsController@update');
Route::delete('models/{model}', 'VehicleModelsController@delete');

Route::get('fuels', 'FuelsController@index');
Route::get('fuels/{fuel}', 'FuelsController@display');
Route::post('fuels', 'FuelsController@store');
Route::put('fuels/{fuel}', 'FuelsController@update');
Route::delete('fuels/{fuel}', 'FuelsController@delete');

Route::get('vehicles/person_types', 'PersonTypesController@index');
Route::get('vehicles/person_types/{personType}', 'PersonTypesController@display');
Route::post('vehicles/person_types', 'PersonTypesController@store');
Route::put('vehicles/person_types/{personType}', 'PersonTypesController@update');
Route::delete('vehicles/person_types/{personType}', 'PersonTypesController@delete');