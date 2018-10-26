<?php

use Illuminate\Support\Facades\Route;

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

// Vendedor Controller
Route::resource("vendedores", 'VendedorController')->only(['index', 'edit', 'update', 'destroy', 'store']);

// Venda Controller
Route::prefix("vendas")->group(function () {
    Route::post("lancar", "VendaController@lancar")->name("vendas.lancar");
});