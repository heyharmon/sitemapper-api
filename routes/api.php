<?php

use Illuminate\Support\Facades\Route;
use DDD\Http\Websites\WebsiteController;
use DDD\Http\Pages\PageController;
use DDD\Http\Contacts\ContactController;
use DDD\Http\Companies\CompanyImportController;
use DDD\Http\Companies\CompanyEnrichmentController;
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

        // Enrich
        Route::post('/get-websites-page-count', [CompanyEnrichmentController::class, 'getWebsitesPageCount']);
        Route::post('/get-utah-principals', [CompanyEnrichmentController::class, 'getUtahPrincipals']);
    });

    // Contacts
    Route::prefix('companies/{company}/contacts')->group(function() {
        Route::get('/', [ContactController::class, 'index']);
        Route::post('/', [ContactController::class, 'store']);
        Route::get('/{contact}', [ContactController::class, 'show']);
        Route::put('/{contact}', [ContactController::class, 'update']);
        Route::delete('/{contact}', [ContactController::class, 'destroy']);
    });

    // Websites
    Route::prefix('companies/{company}/websites')->group(function() {
        Route::get('/', [WebsiteController::class, 'index']);
        Route::post('/', [WebsiteController::class, 'store']);
        Route::get('/{website}', [WebsiteController::class, 'show']);
        Route::put('/{website}', [WebsiteController::class, 'update']);
        Route::delete('/{website}', [WebsiteController::class, 'destroy']);
    });

    // Pages
    Route::prefix('companies/{company}/websites/{website}')->group(function() {
        Route::get('pages/', [PageController::class, 'index']);
        Route::post('pages/', [PageController::class, 'store']);
        Route::get('pages/{page}', [PageController::class, 'show']);
        Route::put('pages/{page}', [PageController::class, 'update']);
        Route::delete('pages/{page}', [PageController::class, 'destroy']);
    });
});