<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;

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
Route::prefix('v1')->group(function () {
    Route::get("/tarea",[TareaController::class,'ListarTarea']);
    Route::get("/tarea/{id}",[TareaController::class,'BuscarTarea']);
    Route::post("/tarea",[TareaController::class,'CrearTarea']);
    Route::delete("/tarea/{id}",[TareaController::class,'EliminarTarea']);
    Route::put("/tarea/{id}",[TareaController::class,'ModificarTarea']);

});
