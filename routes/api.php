<?php

use App\Http\Controllers\Api\EFoxApiController;
use App\Http\Controllers\Api\UserApiController;
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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [UserApiController::class, 'login']);
    Route::get('refresh', [UserApiController::class, 'refresh']);
});

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('store', [UserApiController::class, 'store']);
        Route::post('update/{id}', [UserApiController::class, 'update']);
        Route::delete('{id}', [UserApiController::class, 'delete']);
    });
});

Route::group(['middleware' => 'efox'], function () {
    Route::group(['prefix' => 'transfer'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::post('store', [EFoxApiController::class, 'store']);
            Route::post('update/{id}', [EFoxApiController::class, 'update']);
            Route::delete('{id}', [EFoxApiController::class, 'delete']);
        });
        Route::group(['prefix' => 'course'], function () {
            Route::get('list', [EFoxApiController::class, 'getListCourse']);
            Route::post('store', [EFoxApiController::class, 'storeCourse']);
            Route::post('update/{id}', [EFoxApiController::class, 'updateCourse']);
            Route::delete('{id}', [EFoxApiController::class, 'deleteCourse']);
        });
    });
});