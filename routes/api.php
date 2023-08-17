<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SpeciesApiController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
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

Route::middleware('auth_client')->group(function () {
    Route::apiResource('species', SpeciesApiController::class)->only([
       'show'
    ]);

    Route::post('/upload', [SpeciesApiController::class, 'detectImage']);
});

// Authentication Route
Route::prefix('auth')->group(function(){

    $authController = 'App\Http\Controllers\API\AuthController';

    Route::get('/init', [
        'uses' => $authController.'@init',
        'as' => 'auth.init'
    ])->middleware('auth:api');
    Route::post('/login', [
        'uses' => $authController.'@login',
        'as' => 'auth.login'
    ]);
    Route::post('/register', [
        'uses' => $authController.'@register',
        'as' => 'auth.register'
    ]);
    Route::get('/logout', [
        'uses' => $authController.'@logout',
        'as' => 'auth.logout'
    ])->middleware('auth:api');
});

// User Routes
Route::group(['prefix' => 'user', 'middleware' => ['auth:api', 'user.maintenance']], function(){

    $userController = 'App\Http\Controllers\API\UserController';

    Route::get('/index', [
        'uses' => $userController.'@index',
        'as' => 'user.index',
    ]);
    Route::get('/create', [
        'uses' => $userController.'@create',
        'as' => 'user.create',
    ]);
    Route::post('/store', [
        'uses' => $userController.'@store',
        'as' => 'user.store',
    ]);
    Route::get('/edit/{id}', [
        'uses' => $userController.'@edit',
        'as' => 'user.edit',
    ]);
    Route::post('/update/{id}', [
        'uses' => $userController.'@update',
        'as' => 'user.update',
    ]);
    Route::post('/update_profile/{id}', [
        'uses' => $userController.'@update_profile',
        'as' => 'user.update_profile',
    ]);
    Route::post('/delete', [
        'uses' => $userController.'@delete',
        'as' => 'user.delete',
    ]);
    Route::get('/roles_permissions', [
        'uses' => $userController.'@userRolesPermissions',
        'as' => 'user.roles_permissions',
    ]);

});

//Permissions
Route::group(['prefix' => 'permission', 'middleware' => ['auth:api', 'permission.maintenance']], function(){

    $permissionController = 'App\Http\Controllers\API\PermissionController';

    Route::get('/index', [
        'uses' => $permissionController.'@index',
        'as' => 'permission.index',
    ]);
    Route::get('/create', [
        'uses' => $permissionController.'@create',
        'as' => 'permission.create',
    ]);
    Route::post('/store', [
        'uses' => $permissionController.'@store',
        'as' => 'permission.store',
    ]);
    Route::post('/edit', [
        'uses' => $permissionController.'@edit',
        'as' => 'permission.edit',
    ]);
    Route::post('/update/{id}', [
        'uses' => $permissionController.'@update',
        'as' => 'permission.update',
    ]);
    Route::post('/delete', [
        'uses' => $permissionController.'@delete',
        'as' => 'permission.delete',
    ]);

});

//Roles
Route::group(['prefix' => 'role', 'middleware' => ['auth:api', 'role.maintenance']], function(){

    $roleController = 'App\Http\Controllers\API\RoleController';

    Route::get('/index', [
        'uses' => $roleController.'@index',
        'as' => 'role.index',
    ]);
    Route::get('/create', [
        'uses' => $roleController.'@create',
        'as' => 'role.create',
    ]);
    Route::post('/store', [
        'uses' => $roleController.'@store',
        'as' => 'role.store',
    ]);
    Route::post('/edit', [
        'uses' => $roleController.'@edit',
        'as' => 'role.edit',
    ]);
    Route::post('/update/{id}', [
        'uses' => $roleController.'@update',
        'as' => 'role.update',
    ]);
    Route::post('/delete', [
        'uses' => $roleController.'@delete',
        'as' => 'role.delete',
    ]);

});

//Species
Route::group(['prefix' => 'species2', 'middleware' => ['auth:api', 'species.maintenance']], function(){

    $speciesController = 'App\Http\Controllers\API\SpeciesApiController';

    Route::get('/index', [
        'uses' => $speciesController.'@index',
        'as' => 'species.index',
    ]);
    Route::get('/create', [
        'uses' => $speciesController.'@create',
        'as' => 'species.create',
    ]);
    Route::post('/store', [
        'uses' => $speciesController.'@store',
        'as' => 'species.store',
    ]);
    Route::post('/edit', [
        'uses' => $speciesController.'@edit',
        'as' => 'species.edit',
    ]);
    Route::post('/update/{id}', [
        'uses' => $speciesController.'@update',
        'as' => 'species.update',
    ]);
    Route::post('/delete', [
        'uses' => $speciesController.'@delete',
        'as' => 'species.delete',
    ]);
    Route::post('/import_species', [
        'uses' => $speciesController.'@import_species',
        'as' => 'species.import'
    ]);
    Route::get('/export_species', [
        'uses' => $speciesController.'@export_species',
        'as' => 'species.export'
    ]);
    Route::post('/publish', [
        'uses' => $speciesController.'@publish',
        'as' => 'species.publish'
    ]);

});