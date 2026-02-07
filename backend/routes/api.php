<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExternalDataController;

/*
|--------------------------------------------------------------------------
| API Routes - UMKM Sense
|--------------------------------------------------------------------------
*/

/*
|-------------------------------------------------
| PUBLIC TEST ENDPOINT (UNTUK TEST FE ↔ BE)
|-------------------------------------------------
*/
Route::get('/v1/ping', function () {
    return response()->json([
        'message' => 'BE connected',
    ]);
});

/*
|-------------------------------------------------
| API VERSION v1
|-------------------------------------------------
*/
Route::prefix('v1')->group(function () {

    /*
    |-------------------------
    | Authentication
    |-------------------------
    */
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    /*
    |-------------------------
    | Protected Routes
    |-------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        /*
        | User & Profile
        */
        Route::get('/user/profile', [UserController::class, 'profile']);

        /*
        | Dashboard
        */
        Route::get('/dashboard/summary', [InsightController::class, 'summary']);

        /*
        | Sales / Transactions
        */
        Route::prefix('sales')->group(function () {
            Route::get('/', [SalesController::class, 'index']);
            Route::post('/', [SalesController::class, 'store']);
        });

        /*
        | Inventory
        */
        Route::prefix('inventory')->group(function () {
            Route::post('/update', [InventoryController::class, 'update']);
            Route::get('/low-stock', [InventoryController::class, 'lowStock']);
        });

        /*
        | Insight & Analytics
        */
        Route::prefix('insight')->group(function () {
            Route::get('/generate', [InsightController::class, 'generate']);
            Route::get('/history', [InsightController::class, 'history']);
        });

        /*
        | External Data
        */
        Route::prefix('external-data')->group(function () {
            Route::get('/trends', [ExternalDataController::class, 'trends']);
            Route::get('/events', [ExternalDataController::class, 'events']);
            Route::get('/weather', [ExternalDataController::class, 'weather']);
        });

        /*
        | Reports
        */
        Route::prefix('report')->group(function () {
            Route::get('/export', [ReportController::class, 'export']);
        });

    });
});
