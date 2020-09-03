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

Route::get('/test', 'PaymentController@test');

Route::get('/', 'HomeController@index');

Route::get('/manager/confirmation/{userid?}/{token?}', 'ManagerController@confirmation')->name('manager_confirmation');
Route::any('/manager/signup', 'ManagerController@signup')->name('manager.signup');

Route::get('/service_details/{idservice}', 'HomeController@getService');

Route::get('/logout', function(){
    auth()->logout();

    return redirect('/login');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('/', 'AdminController@index');
    Route::get('/categories', 'AdminController@serviceCategories');
    Route::post('/add_service', 'AdminController@addService');
    Route::get('/get_services', 'AdminController@getServices');
    Route::delete('/delete_service', 'AdminController@deleteService');

    Route::delete('/manager', 'AdminController@deleteManager');
    Route::any('/managers', 'AdminController@managers');
});

Route::group(['prefix' => 'userpanel', 'middleware' => ['auth']], function(){
    Route::get('/show_{idservice}', 'UserController@index');
    Route::get('/', 'UserController@index');
    Route::post('/add-new-order', 'UserController@add_new_order');
    Route::any('/profile/{type?}', 'UserController@profile');
});


Route::group(['prefix' => 'manager', 'middleware' => ['auth']], function(){
    Route::get('/', 'ManagerController@index');
    Route::get('/clients', 'ManagerController@clients');
});


Route::post('/pay_service', 'UserController@pay_service_guest');
Route::get('/buy_{idservice?}_{idmanager?}', 'HomeController@index');


Auth::routes();
//Route::get('/login', 'UserController@loginUser')->name('login');

Route::get('/tinkoff/callback', 'PaymentController@callback')->name('tinkoff-callback');
Route::get('/tinkoff/{status}', 'PaymentController@paymentStatus')->name('tinkoff-status');
