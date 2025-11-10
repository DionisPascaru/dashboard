<?php

use App\Http\Controllers\API\Admin\Client\ClientController;
use App\Http\Controllers\API\Auth\AuthController;
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
    Route::post('/users/search', [UsersApiController::class, 'search']);
    Route::group(['prefix' => 'user'], function (){
        Route::get('/{id}', [UsersApiController::class, 'show']);
        Route::post('', [UsersApiController::class, 'create']);
        Route::put('/{id}', [UsersApiController::class, 'update']);
        Route::delete('/{id}', [UsersApiController::class, 'delete']);
    });

    // Projects
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

    // Clients
    Route::group(['prefix' => 'clients'], function () {
        Route::post('/search', [ClientController::class, 'search']);
        Route::post('/', [ClientController::class, 'create']);
        Route::put('/{client}', [ClientController::class, 'update']);
        Route::get('/{client}', [ClientController::class, 'read']);
        Route::delete('/{client}', [ClientController::class, 'delete']);

        // Owned organizations
        Route::group(['prefix' => '{client}/organizations'], function () {
            Route::get('/', [ClientController::class, 'readOrganizations']);
        });
    });
});
