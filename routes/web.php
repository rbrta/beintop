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
    Route::get('/', 'UserController@index');
    Route::post('/add-new-order', 'UserController@add_new_order');
    Route::any('/profile/{type?}', 'UserController@profile');
});


Route::group(['prefix' => 'manager', 'middleware' => ['auth']], function(){
    Route::get('/', 'ManagerController@index');
});



Route::get('/home', function(){ return redirect()->to('/client'); });

Route::get('/new-order', 'UserController@new_order');

Route::post('/pay_service', 'UserController@pay_service_guest');


Route::post('/payment/callback', 'PaymentController@callback');
Route::post('/payment/success', 'PaymentController@success');
Route::post('/payment/failure', 'PaymentController@failure');
Route::post('/payment/pending', 'PaymentController@pending');
Route::get('/pay', 'PaymentController@pay');
Route::get('/test', 'PaymentController@test');



Auth::routes();

Route::get('/login', 'UserController@loginUser')->name('login');


Route::get('/{idservice?}', 'HomeController@index');