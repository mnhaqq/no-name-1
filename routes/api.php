<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\RegionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('regions', RegionController::class);

Route::apiResource('districts', DistrictController::class)->except(['store', 'index']);
Route::get('/regions/{region}/districts', [DistrictController::class, 'indexByRegion']);
Route::post('/regions/{region}/districts', [DistrictController::class, 'store']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
