<?php

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

Route::get('services/categories', 'Api\PagesController@categories');
Route::get('socials', 'Api\PagesController@socials');
Route::get('services/{type?}', 'Api\PagesController@services');
Route::match(['get', 'post'], 'manager/confirm', 'Api\ManagerController@confirmation');

Route::prefix('auth')->group(static function() {
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout')->middleware('auth:api');
    Route::get('user', 'Api\AuthController@user')->middleware('auth:api');
});

Route::prefix('user')->middleware('auth:api')->group(static function() {
    Route::get('orders/{id?}', 'Api\OrdersController@show');
    Route::post('orders', 'Api\OrdersController@create');
    Route::get('accounts', 'Api\AccountsController@show');
    Route::post('accounts', 'Api\AccountsController@store');
    Route::match(['get', 'post'], 'accounts/change-tariff', 'Api\AccountsController@changeTariff');
    Route::match(['get', 'post'], 'accept-offer', 'Api\ManagerController@acceptOffer');
});

Route::prefix('manager')->middleware(['auth:api', 'manager'])->group(static function() {
    Route::match(['get', 'post', 'delete'], 'clients', 'Api\ManagerController@clients');
    Route::post('add-offer', 'Api\ManagerController@addOffer');
});

Route::prefix('admin')->middleware(['auth:api', 'admin'])->group(static function() {
    Route::match(['post', 'delete'], 'services', 'Api\PagesController@services');
    Route::match(['get', 'post', 'delete'], 'managers', 'Api\PagesController@managers');
    Route::match(['get', 'delete'], 'manager/{id?}/clients', 'Api\ManagerController@clients');
    Route::match(['post', 'delete'], 'socials', 'Api\PagesController@socials');
    Route::get('socials', 'Api\PagesController@socialsOnly');
});

Route::get('users', 'Api\PagesController@users')->middleware('auth:api');
Route::post('tinkoff/callback', 'PaymentController@callback')->name('tinkoff-callback');
