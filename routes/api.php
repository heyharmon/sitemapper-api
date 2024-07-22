<?php

use Illuminate\Support\Facades\Route;
use DDD\Http\Websites\WebsiteController;
use DDD\Http\Pages\PageController;

Route::middleware('auth:sanctum')->group(function() {

    // Websites
    Route::prefix('websites')->group(function() {
        Route::get('/', [WebsiteController::class, 'index']);
        Route::post('/', [WebsiteController::class, 'store']);
        Route::get('/{website}', [WebsiteController::class, 'show']);
        Route::put('/{website}', [WebsiteController::class, 'update']);
        Route::delete('/{website}', [WebsiteController::class, 'destroy']);
    });

    // Pages
    Route::prefix('websites/{website}')->group(function() {
        Route::get('pages/', [PageController::class, 'index']);
        Route::post('pages/', [PageController::class, 'store']);
        Route::get('pages/{page}', [PageController::class, 'show']);
        Route::put('pages/{page}', [PageController::class, 'update']);
        Route::delete('pages/{page}', [PageController::class, 'destroy']);
    });
});