<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::middleware([
    'auth:sanctum',
    'verified'
])->group(function () {

    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('me', App\Http\Controllers\MeController::class);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('posts', App\Http\Controllers\PostController::class);

});
