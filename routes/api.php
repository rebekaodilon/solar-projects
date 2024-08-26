<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController; 
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProjectController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});


Route::middleware('auth:sanctum')->group(function(){

    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('projects', ProjectController::class);
    
    Route::group(['prefix' => 'projects'], function () {
        Route::get('{id}/equipments', [ProjectController::class, 'listEquipments']);
        Route::post('{id}/equipments', [ProjectController::class, 'storeEquipment']);
        Route::put('{id}/equipments/{equipmentId}', [ProjectController::class, 'updateEquipment']);
        Route::delete('{id}/equipments/{equipmentId}', [ProjectController::class, 'destroyEquipment']);
    });

    Route::get('equipments', [ProjectController::class, 'listAllEquipments']);
    Route::get('installation_types', [ProjectController::class, 'listAllInstallationTypes']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
