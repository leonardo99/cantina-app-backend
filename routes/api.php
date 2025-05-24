<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)
->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware(JwtMiddleware::class);
    });
    
    Route::get('/user', 'user')->middleware(JwtMiddleware::class);
});

Route::controller(UserController::class)
->prefix('user')
->group(function() {
    Route::post('/', 'store');
});

Route::prefix('admin')
->middleware(AdminMiddleware::class)
->group(function () {
    Route::prefix('/category')
    ->group(function() {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
    });
});