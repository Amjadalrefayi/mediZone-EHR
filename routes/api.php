<?php

use App\Http\API\V1\Controllers\Language\LanguageController;
use App\Http\API\V1\Controllers\Permission\PermissionController;
use App\Http\API\V1\Controllers\Role\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\API\V1\Controllers\User\UserController;
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

Route::group(['prefix' => 'v1'], function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::apiResources([
                'roles' => RoleController::class,
                'users' => UserController::class,
                'permissions' => PermissionController::class,
                'languages' => LanguageController::class,
            ]);

            Route::prefix('users')->group(function () {
                Route::post('{user}/roles', [UserController::class, 'storeRoles']);
                Route::get('{user}/roles', [UserController::class, 'indexRoles']);
                Route::post('language', [UserController::class, 'storeUserLanguage']);
            });

            Route::prefix('roles')->group(function () {
                Route::get('{role}/permissions', [RoleController::class, 'indexPermissions']);
                Route::post('{role}/permissions', [RoleController::class, 'storePermissions']);
            });
        });
    });

});
