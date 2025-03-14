<?php

use App\Http\Controllers\Api\BikeController;
use App\Http\Controllers\Api\RentalController;
use Illuminate\Support\Facades\Route;

// Add this line to debug routes
Route::get('/', function() {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('v1')->group(function () {
    // Bikes routes
    Route::get('/bikes', [BikeController::class, 'index']);
    Route::get('/bikes/{bike}', [BikeController::class, 'show']);

    // Rentals routes
    Route::get('/rentals', [RentalController::class, 'index']);
    Route::post('/rentals', [RentalController::class, 'store']);
    Route::post('/rentals/{rental}/complete', [RentalController::class, 'complete']);
});