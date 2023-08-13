<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\TourController;
use App\Http\Controllers\API\V1\TravelController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// PUBLIC ROUTES 
// Route::prefix('v1')>group( function(){
//     Route::controller(TravelController::class)->group(function () 
//     {
//         Route::get('travels', 'index')->name('travels');
//     });
// });

Route::prefix('v1')->group(function () {
    Route::controller(TravelController::class)->group(function () {
        Route::get('/travels', 'index')->name('travels');
        Route::get('/travels/{travel}/tours', 'index')->name('travels');
    });
    Route::get('/travels/{travel:slug}/tours', [TourController::class,'index'])->name('tours');
});