<?php

use App\Http\Controllers\Api\Album;
use App\Http\Controllers\Api\Customer;
use App\Http\Controllers\Api\Status;
use App\Http\Controllers\Api\WebScraping;
use App\Http\Controllers\Api\Category;
use App\Http\Controllers\Api\Menu;
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
        });
        Route::prefix('albums')->group(function () {
            Route::get('/uploaded', [Album::class, 'index']);
            Route::post('/upload', [Album::class, 'upload']);
        });
        Route::prefix('scrape')->group(function () {
            Route::get('/sites', [WebScraping::class, 'site']);
            Route::post('/', [WebScraping::class, 'scrape']);
        });
    });

    Route::prefix('master')->group(function () {
        Route::prefix('statuses')->group(function () {
            Route::get('/', [Status::class, 'index']);
            Route::post('/', [Status::class, 'store']);
            Route::put('/{id}', [Status::class, 'update']);
        });
        Route::apiResource('categories', Category::class);
        Route::prefix('products')->group(function () {
            Route::get('/search', [Product::class, 'search']);
            Route::get('/{id}', [Product::class, 'show']);
            Route::post('/', [Product::class, 'store']);
        });
        Route::prefix('menus')->group(function () {
            Route::get('/', [Menu::class, 'index']);
        });
    });
});

Route::get('/sample', function () {
    return response()->json(['msg' => '成功']);
});
