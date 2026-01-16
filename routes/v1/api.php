<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\PartnerTypeController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PackageItemController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TransactionItemController;
use App\Http\Controllers\Api\StockOpnameController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [AuthController::class, 'getUser']);
    Route::apiResource("product-categories", ProductCategoryController::class);
    Route::apiResource("units", UnitController::class);
    Route::apiResource("partner-types", PartnerTypeController::class);
    Route::apiResource("partners", PartnerController::class);
    Route::apiResource("products", ProductController::class);
    Route::apiResource("packages", PackageController::class);
    Route::prefix('packages/{package}')->group(function () {
        Route::apiResource("items", PackageItemController::class)->except('show');
    });
    Route::apiResource("transactions", TransactionController::class);
    Route::prefix('transactions/{transaction}')->group(function () {
        Route::apiResource("items", TransactionItemController::class);
    });

    Route::apiResource("stock-opname", StockOpnameController::class)->only('index');
});
