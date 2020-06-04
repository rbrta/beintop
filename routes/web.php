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

Route::get('/home', function(){ return redirect()->to('/client'); });
Route::get('/client', 'UserController@index');
Route::post('/pay_service', 'UserController@pay_service_guest');


Route::post('/payment/callback', 'TestController@callback');
Route::post('/payment/success', 'TestController@success');
Route::post('/payment/failure', 'TestController@failure');
Route::post('/payment/pending', 'TestController@pending');
Route::get('/pay', 'TestController@pay');
Route::get('/test', 'TestController@test');



Auth::routes();
Route::get('/login', 'UserController@loginUser')->name('login');
Route::post('/signup', 'UserController@signupUser');