<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductByCategoryController;
use App\Http\Controllers\Client\CartController;
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

Route::controller(UserController::class)
->prefix('user')
->group(function() {
    Route::post('/', 'store');
});

Route::controller(AuthController::class)
->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware(JwtMiddleware::class);
    });
    
    Route::get('/user', 'user')->middleware(JwtMiddleware::class);
});


Route::prefix('user')
->middleware(JwtMiddleware::class)
->group(function () {
    Route::get('category/{category}', [ProductByCategoryController::class, 'index']);
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::get('/item/{cartItem}', [CartController::class, 'show']);
    Route::delete('/cart/{cart}/item/{item}', [CartController::class, 'destroy']);

});

Route::prefix('admin')
->middleware(AdminMiddleware::class)
->group(function () {
    Route::prefix('/category')
    ->group(function() {
        Route::get('/{category}', [ProductByCategoryController::class, 'index']);
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
    });

    Route::prefix('/product')
    ->group(function() {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::prefix('/{product}')->group(function() {
            Route::get('/', [ProductController::class, 'show']);
            Route::put('/update', [ProductController::class, 'update']);
            Route::delete('/delete', [ProductController::class, 'destroy']);
        });
    });
});