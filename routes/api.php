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


Route::get('services', 'Api\PagesController@services');

Route::prefix('auth')->group(static function() {
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::get('user', 'Api\AuthController@user')->middleware('auth:api');
});

Route::prefix('manager')->middleware('auth:api')->group(static function() {
    Route::get('manager/clients', 'Api\ManagerController@clients');
    Route::post('manager/addclient', 'Api\ManagerController@addClient');
});
