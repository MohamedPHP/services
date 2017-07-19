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

Route::get('/getAllInfo', 'HomeController@getAllInfo');

Route::group(['middleware' => 'auth'], function () {
    // services
    Route::post('/AddService', 'ServicesController@store');
    Route::get('/MyServices/{length?}', 'ServicesController@MyServices');
    // orders
    Route::get('/AddOrder/{id}', 'OrdersController@AddOrder');
    Route::get('/getMyPurchaseOrders', 'OrdersController@getMyPurchaseOrders');
    Route::get('/getMyIncomeOrders', 'OrdersController@getMyIncomeOrders');
    Route::get('/GetOrderById/{id}', 'OrdersController@GetOrderById');
    Route::get('/ChangeStatus/{id}/{status}', 'OrdersController@ChangeStatus');
    Route::get('/finishOrder/{id}/{status}', 'OrdersController@finishOrder');
    Route::get('/deleteOrder/{id}', 'OrdersController@deleteOrder');
    // comments
    Route::post('/AddComment', 'CommentsController@AddComment');
    Route::get('/getAllComments/{id}', 'CommentsController@getAllComments');
    // messages
    Route::post('/SendMessage', 'MessagesController@SendMessage');
    Route::get('/getUserMessages', 'MessagesController@getUserMessages');
    Route::get('/SentMessages', 'MessagesController@SentMessages');
    Route::get('/UnreadMessages', 'MessagesController@UnreadMessages');
    Route::get('/ReadMessages', 'MessagesController@ReadMessages');
    Route::get('/GetMessageById/{id}/{title}', 'MessagesController@GetMessageById');
    // wishlist
    Route::get('/AddToWishList/{service_id}', 'WishlistController@AddToWishList');
    Route::get('/GetUserWishList', 'WishlistController@GetUserWishList');
    Route::get('/DeleteWishList/{id}', 'WishlistController@DeleteWishList');
    // vote
    Route::get('/AddNewVote', 'VoteController@AddNewVote');
    // payments
    Route::get('/getAuthUser', 'UserController@getAuthUser');
    Route::post('/AddCreditNow', 'PaypalController@AddCreditNow');
    Route::get('/getAllCharges', 'UserController@getAllCharges');
    Route::get('/getAllpayments', 'UserController@getAllpayments');
    Route::get('/Profits', 'UserController@Profits');
    Route::get('/getAllBalance', 'UserController@getAllBalance');
    // notifications
    Route::get('/getUserNotifications/{length?}', 'UserController@getUserNotifications');
    Route::get('/getNotificationList', 'UserController@getNotificationList');
});
// services
Route::get('/getAllServices/{length?}', 'ServicesController@getAllServices');
Route::get('/service/{id}', 'ServicesController@getServiceById');
Route::get('/getUserServices/{id}/{length?}', 'ServicesController@getUserServices');
Route::get('/CategoryServices/{id}/{length?}', 'CategoryController@CategoryServices');
Route::get('/getAllCategories', 'CategoryController@getAllCategories');
//


Route::group(['middleware' => 'admin', 'prefix' => 'admincp'], function () {
    Route::get('/', 'AdminController@index');
    // services start
    Route::get('/services/{sort?}', 'AdminServicesController@index');
    Route::get('/service-delete/{id}', 'AdminServicesController@delete')->name('service.delete');
    Route::get('/service-accept/{id}', 'AdminServicesController@accept')->name('service.accept');
    Route::get('/service-reject/{id}', 'AdminServicesController@reject')->name('service.reject');
    Route::get('/service-edit/{id}', 'AdminServicesController@edit')->name('service.edit');
    Route::post('/service-update/{id}', 'AdminServicesController@update')->name('service.update');
    // services end

    // orders start
    Route::get('/orders/{sort?}', 'AdminOrdersController@index');
    Route::get('/orders-view/{id}', 'AdminOrdersController@view')->name('order.view');
    Route::post('/order-changestatus', 'AdminOrdersController@changeStatus')->name('changestatus.admin');
    Route::get('/order/getServiceOrders/{service_id}/{sort?}', 'AdminOrdersController@getServiceOrders')->name('getServiceOrders');
    // orders end
});









//
