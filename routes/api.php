<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello from Laravel on Railway! 🎉'
    ]);
});

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware(['auth:api'])->group(function () {
    // auth
    Route::post('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);

    // role
    Route::get('role', [RoleController::class, 'all']);
});
