<?php

use App\Http\Controllers\AIPredictionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\CustomRouteController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LocationTrackingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TownController;
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

    Route::apiResource('buses', BusController::class);
    Route::apiResource('drivers', DriverController::class);
    Route::apiResource('routes', RouteController::class);
    Route::apiResource('towns', TownController::class);
    Route::apiResource('location-tracking', LocationTrackingController::class);
    Route::apiResource('ai-predictions', AIPredictionController::class);

    Route::get('/bus-routes', [CustomRouteController::class, 'busRoutes']);
    Route::get('/driver/{id}/buses', [CustomRouteController::class, 'driverBuses']);
    Route::get('/routes/{id}/towns', [CustomRouteController::class, 'routeTowns']);
    Route::post('/routes/{id}/towns', [CustomRouteController::class, 'syncRouteTowns']);
    Route::post('/driver-profile', [CustomRouteController::class, 'madeDriverProfile']);
    Route::get('driver-profile/{driverId}', [CustomRouteController::class, 'getDriverProfile']);
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
