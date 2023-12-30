<?php

use App\Http\Controllers\API\AdminManagerController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Project\ProjectCategoriesApiController;
use App\Http\Controllers\API\Project\ProjectsApiController;
use App\Http\Controllers\API\User\RolesApiController;
use App\Http\Controllers\API\User\UsersApiController;
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
    // Admin
    Route::get('/auth-user', [AuthController::class, 'getAuthUser']);

    // Users
    Route::get('/users', [UsersApiController::class, 'index']);
    Route::post('/users/search', [UsersApiController::class, 'search']);
    Route::group(['prefix' => 'user'], function (){
        Route::get('/{id}', [UsersApiController::class, 'show']);
        Route::post('', [UsersApiController::class, 'create']);
        Route::put('/{id}', [UsersApiController::class, 'update']);
        Route::delete('/{id}', [UsersApiController::class, 'delete']);
    });

    // Projects
    Route::get('/projects', [ProjectsApiController::class, 'index']);
    Route::post('/projects/search', [ProjectsApiController::class, 'search']);
    Route::group(['prefix' => 'project'], function () {
        Route::get('/{id}', [ProjectsApiController::class, 'show']);
        Route::post('', [ProjectsApiController::class, 'create']);
        Route::post('/{id}', [ProjectsApiController::class, 'update']);
        Route::delete('/{id}', [ProjectsApiController::class, 'delete']);
        Route::post('/{id}/file-upload', [ProjectsApiController::class, 'fileUpload']);
        Route::post('/{id}/image-upload', [ProjectsApiController::class, 'imageUpload']);
        Route::delete('/{id}/image-remove', [ProjectsApiController::class, 'imageRemove']);
    });

    // Project categories
    Route::get('/project-categories', [ProjectCategoriesApiController::class, 'index']);

    // Roles
    Route::get('/roles', [RolesApiController::class, 'index']);
});
