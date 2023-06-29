<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectCategoriesApiController;
use App\Http\Controllers\API\ProjectsApiController;
use App\Http\Controllers\API\UsersApiController;
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
    // Users
    Route::get('/users', [UsersApiController::class, 'index']);
    Route::group(['prefix' => 'user'], function (){
        Route::get('/{id}', [UsersApiController::class, 'show']);
        Route::post('', [UsersApiController::class, 'create']);
        Route::put('/{id}', [UsersApiController::class, 'update']);
        Route::delete('/{id}', [UsersApiController::class, 'delete']);
    });

    // Projects
    Route::get('/projects', [ProjectsApiController::class, 'index']);
    Route::group(['prefix' => 'project'], function () {
        Route::get('/{id}', [ProjectsApiController::class, 'show']);
        Route::post('', [ProjectsApiController::class, 'create']);
        Route::post('/{id}', [ProjectsApiController::class, 'update']);
        Route::delete('/{id}', [ProjectsApiController::class, 'delete']);
    });

    // Project categories
    Route::get('/project-categories', [ProjectCategoriesApiController::class, 'index']);
});
