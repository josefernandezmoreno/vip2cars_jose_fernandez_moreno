<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ClienteVehiculoController;

Route::get('/', function () {
    return view('welcome');
});

//mantenedor clientes
Route::resource('clientes', ClienteController::class);
Route::post('/clientes/{id}', [ClienteController::class, 'update']);
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

//mantenedor vechiulos
Route::resource('vehiculos', VehiculoController::class);
Route::post('/vehiculos/{id}', [VehiculoController::class, 'update']);
Route::delete('/vehiculos/{id}', [VehiculoController::class, 'destroy']);

//mantenedor cliente vehiculo
Route::resource('cliente_vehiculo', ClienteVehiculoController::class);
Route::post('/cliente_vehiculo/{id}', [ClienteVehiculoController::class, 'update']);
Route::delete('/cliente_vehiculo/{id}', [ClienteVehiculoController::class, 'destroy']);