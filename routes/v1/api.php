<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\PartnerTypeController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');
Route::apiResource("product-categories", ProductCategoryController::class)->middleware('auth:sanctum');
Route::apiResource("units", UnitController::class)->middleware('auth:sanctum');
Route::apiResource("partner-types", PartnerTypeController::class)->middleware('auth:sanctum');
