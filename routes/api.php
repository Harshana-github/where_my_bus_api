<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello from Laravel on Railway! 🎉'
    ]);
});

// Route to run migration **without seeder**
Route::get('/migrate-only', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migration done without seeder!';
});

// Route to run migration **with seeder**
Route::get('/migrate-with-seeder', function () {
    Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
    return 'Migration and seeding completed!';
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
