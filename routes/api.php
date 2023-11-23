<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiGPS;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('checklog', function(){
//     dd('dawdaw');
// });
// Route::group(['middleware' => 'userpin'], function() {
    // Route::post('/checklog_store', [\App\Http\Controllers\Api\ApiPresensiController::class], 'checklog_store');
// });
    
    
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    //start route presensi gps
    Route::get('/presensi_gps', [PresensiGPS::class, 'index']);
    Route::get('/presensi_gps/{id}', [PresensiGPS::class, 'show']);
    Route::post('/presensi_gps', [PresensiGPS::class, 'store']);
    Route::put('/presensi_gps/{id}', [PresensiGPS::class, 'update']);
    Route::delete('/presensi_gps/{id}', [PresensiGPS::class, 'destroy']);    
    //end route presensi gps
    
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        Route::post('/checklog', [\App\Http\Controllers\Api\ApiPresensiController::class, 'checklog_store']);
        Route::get('/validate-token', [\App\Http\Controllers\Api\ApiPresensiController::class, 'validateToken']);

        Route::post('/test', function(){
            return view('test');
        });

});