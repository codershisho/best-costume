<?php

use App\Http\Controllers\Api\Album;
use App\Http\Controllers\Api\Customer;
use App\Http\Controllers\Api\Status;
use App\Http\Controllers\Api\WebScraping;
use App\Http\Controllers\Api\Category;
use App\Http\Controllers\Api\Favorite;
use App\Http\Controllers\Api\Menu;
use App\Http\Controllers\Api\Order;
use App\Http\Controllers\Api\Product;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', LogoutController::class)->name('logout');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('bc')->group(function () {

    Route::prefix('admin')->group(function () {
        Route::prefix('customers')->group(function () {
            Route::get('/', [Customer::class, 'index']);
            Route::get('/search', [Customer::class, 'search']);
            Route::post('/', [Customer::class, 'store']);
            Route::put('/{id}', [Customer::class, 'update']);
        });
        Route::prefix('albums')->group(function () {
            Route::get('/uploaded', [Album::class, 'index']);
            Route::post('/upload', [Album::class, 'upload']);
            Route::delete('/uploaded', [Album::class, 'delete']);
        });
        Route::prefix('scrape')->group(function () {
            Route::get('/sites', [WebScraping::class, 'site']);
            Route::post('/', [WebScraping::class, 'scrape']);
        });
        Route::prefix('orders')->group(function () {
            Route::get('/', [Order::class, 'search']);
        });
    });

    Route::prefix('master')->group(function () {
        Route::prefix('statuses')->group(function () {
            Route::get('/', [Status::class, 'index']);
            Route::post('/', [Status::class, 'store']);
            Route::put('/{id}', [Status::class, 'update']);
            Route::delete('/{id}', [Status::class, 'delete']);
        });
        Route::apiResource('categories', Category::class);
        Route::prefix('products')->group(function () {
            Route::get('/search', [Product::class, 'search']);
            Route::get('/{id}', [Product::class, 'show']);
            Route::post('/{id}/edit', [Product::class, 'update']);
            Route::post('/', [Product::class, 'store']);
            Route::delete('/', [Product::class, 'delete']);
            Route::post('/update_order', [Product::class, 'order']);
        });
        Route::prefix('menus')->group(function () {
            Route::get('/', [Menu::class, 'index']);
        });
    });

    Route::prefix('customer/{id}')->group(function () {
        Route::prefix('orders')->group(function () {
            Route::post('/', [Order::class, 'store']);
            Route::put('/{order_id}', [Order::class, 'update']);
        });
        Route::prefix('favorites')->group(function () {
            Route::get('/', [Favorite::class, 'search']);
            Route::post('/', [Favorite::class, 'store']);
        });
    });
});

Route::get('/sample', function () {
    return response()->json(['msg' => '成功']);
});
