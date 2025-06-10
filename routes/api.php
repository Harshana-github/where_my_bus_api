<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;


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

Route::get('/artisan/clear-all', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return '✅ Cache cleared';
});

Route::get('/artisan/route-list', function () {
    Artisan::call('route:list', ['--json' => true]);
    $output = Artisan::output();
    return Response::make($output, 200, ['Content-Type' => 'application/json']);
});

Route::get('/test-register', function () {
    $request = Request::create('/api/auth/register', 'POST', [
        'name' => 'A',
        'email' => 'admin@gmail.com',
        'password' => 'kSG2LbN8Kdh',
        'password_confirmation' => 'kSG2LbN8Kdh',
        'user_type' => 'admin',
    ]);

    return app()->handle($request);
});

Route::get('/users', function () {
    return response()->json(User::all());
});

Route::get('/departments', [DepartmentController::class, 'index']);
Route::post('/departments', [DepartmentController::class, 'store']);

Route::post('/test-post', function (Request $request) {
    return response()->json([
        'message' => 'POST route works!',
        'received' => $request->all()
    ]);
});

Route::any('/debug-method', function (Request $request) {
    return response()->json([
        'method' => $request->method(),
        'data' => $request->all()
    ]);
});
