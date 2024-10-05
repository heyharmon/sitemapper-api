<?php

use Illuminate\Support\Facades\Route;
use DDD\Http\Websites\WebsitePageCountController;
use DDD\Http\Websites\WebsiteController;
use DDD\Http\Pages\PageController;
use DDD\Http\Companies\CompanyImportController;
use DDD\Http\Companies\CompanyController;

Route::middleware('auth:sanctum')->group(function() {

    // Companies
    Route::prefix('companies')->group(function() {
        Route::get('/', [CompanyController::class, 'index']);
        Route::post('/', [CompanyController::class, 'store']);
        Route::get('/{company}', [CompanyController::class, 'show']);
        Route::put('/{company}', [CompanyController::class, 'update']);
        Route::delete('/{company}', [CompanyController::class, 'destroy']);

        // Import
        Route::post('/import/outscraper', [CompanyImportController::class, 'outscraper']);
    });

    // Websites
    Route::prefix('websites')->group(function() {
        Route::get('/', [WebsiteController::class, 'index']);
        Route::post('/', [WebsiteController::class, 'store']);
        Route::get('/{website}', [WebsiteController::class, 'show']);
        Route::put('/{website}', [WebsiteController::class, 'update']);
        Route::delete('/{website}', [WebsiteController::class, 'destroy']);

        // Actions
        Route::post('/{website}/get-page-count', [WebsitePageCountController::class, 'store']);
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