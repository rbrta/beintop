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
| is assigned the "api" middleware grкoup. Enjoy building your API!
|
*/

Route::get('services', 'Api\PagesController@services');
Route::get('services/categories', 'Api\PagesController@categories');
Route::match(['get', 'post'], 'manager/confirm', 'Api\ManagerController@confirmation');

Route::prefix('auth')->group(static function() {
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout')->middleware('auth:api');
    Route::get('user', 'Api\AuthController@user')->middleware('auth:api');
});

Route::prefix('user')->middleware('auth:api')->group(static function() {
    Route::get('orders', 'Api\OrdersController@show');
    Route::post('orders', 'Api\OrdersController@create');
    Route::get('accounts', 'Api\AccountsController@show');
    Route::match(['get', 'post'], 'accounts/change-tariff', 'Api\AccountsController@changeTariff');
    Route::match(['get', 'post'], 'accept-offer', 'Api\ManagerController@acceptOffer');
});

Route::prefix('manager')->middleware('auth:api')->group(static function() {
    Route::match(['get', 'post'], 'clients', 'Api\ManagerController@clients');
    Route::post('add-offer', 'Api\ManagerController@addOffer');
});

Route::prefix('admin')->middleware('auth:api')->group(static function() {
    Route::match(['post', 'delete'], 'services', 'Api\PagesController@services');
    Route::match(['get', 'post', 'delete'], 'managers', 'Api\PagesController@managers');
});
Route::get('users', 'Api\PagesController@users')->middleware('auth:api');
Route::post('tinkoff/callback', 'PaymentController@callback')->name('tinkoff-callback');
