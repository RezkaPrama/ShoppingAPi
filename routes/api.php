<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShoppingController;

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

/**
 * Route API Auth
 */
Route::post('/users/login', [AuthController::class, 'login'])->name('api.customer.login');
Route::post('/users/signup', [AuthController::class, 'signup'])->name('api.customer.signup');
Route::get('/users/user', [AuthController::class, 'getUser'])->name('api.customer.user');

/**
 * Route Shopping
 */
Route::post('/shopping', [ShoppingController::class, 'create']);
Route::get('/shopping', [ShoppingController::class, 'index']);
Route::get('/shopping/{slug?}', [ShoppingController::class, 'show'])->name('shopping.show');
Route::put('/shopping/{id}', [ShoppingController::class, 'update']);
Route::delete('/shopping/{id}', [ShoppingController::class, 'delete']);

