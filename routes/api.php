<?php

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

//Route::get('user',[\App\Http\Controllers\AuthenticationController::class, 'register']);
/*Route::post('register',[\App\Http\Controllers\AuthenticationController::class, 'authenticate']);
Route::post('login',[\App\Http\Controllers\DataController::class, 'open']);
Route::get('getUsers',[\App\Http\Controllers\AuthenticationController::class, 'getUsers']);
*/
Route::post('register', [\App\Http\Controllers\AuthenticationController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\AuthenticationController::class, 'authenticate']);
    Route::get('open', [\App\Http\Controllers\DataController::class, 'open']);
    Route::get('getUsers',[\App\Http\Controllers\AuthenticationController::class, 'getUsers']);
    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('user', 'AuthenticationController@getAuthenticatedUser');
        Route::get('closed', 'DataController@closed');
    });
