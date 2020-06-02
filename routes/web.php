<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

// Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
Route::group(['prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index');
    Route::get('/categories', 'AdminController@serviceCategories');
    Route::post('/add_service', 'AdminController@addService');
    Route::get('/get_services', 'AdminController@getServices');
    Route::delete('/delete_service', 'AdminController@deleteService');
});

Route::get('/client', 'UserController@index');
Route::post('/pay_service', 'UserController@pay_service_guest');


Route::get('/payment/success', 'TestController@success');
Route::get('/payment/failure', 'TestController@failure');
Route::get('/payment/callback', 'TestController@callback');
Route::get('/pay', 'TestController@pay');

