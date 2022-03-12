<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersApiController;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/users', [UsersApiController::class, 'index']);

    Route::group(['prefix' => 'user'], function (){
        Route::get('/{id}', [UsersApiController::class, 'show']);
        Route::delete('/{id}', [UsersApiController::class, 'delete']);
    });
});
