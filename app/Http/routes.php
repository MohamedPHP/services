<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');


// services
Route::post('/AddService', 'ServicesController@store');
Route::get('/MyServices', 'ServicesController@MyServices');
Route::get('/service/{id}', 'ServicesController@getServiceById');
Route::get('/getUserServices/{id}', 'ServicesController@getUserServices');


Route::get('/AddOrder/{id}', 'OrdersController@AddOrder');
Route::get('/getMyPurchaseOrders', 'OrdersController@getMyPurchaseOrders');
Route::get('/getMyIncomeOrders', 'OrdersController@getMyIncomeOrders');
Route::get('/GetOrderById/{id}', 'OrdersController@GetOrderById');
