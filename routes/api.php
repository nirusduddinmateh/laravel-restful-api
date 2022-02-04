<?php

use App\Http\Controllers\AuthController;
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

Route::group([
    'middleware' => 'api'
], function () {
    Route::get('dashboard', [App\Http\Controllers\APIS\HomeController::class, 'dashboard'])->name('api.dashboard');
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('register', AuthController::class . '@register')->name('register');
    Route::post('login', AuthController::class . '@login')->name('login');
});


Route::group([
    'middleware' => 'auth:api'
], function () {

    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::get('me', AuthController::class . '@me')->name('me');
        Route::apiResource('me/posts', App\Http\Controllers\APIS\MeController::class);

        Route::post('logout', AuthController::class . '@logout')->name('logout');
    });

    Route::apiResource('users', App\Http\Controllers\APIS\UserController::class);
    Route::apiResource('posts', App\Http\Controllers\APIS\PostController::class);
});
