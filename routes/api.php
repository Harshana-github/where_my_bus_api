<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


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

// Artisan Commands 
Route::get('/artisan/migrate-only', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migration done without seeder!';
});

Route::get('/artisan/migrate-with-seeder', function () {
    Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
    return 'Migration and seeding completed!';
});

Route::get('/artisan/clear-all', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return '✅ Cache cleared';
});
