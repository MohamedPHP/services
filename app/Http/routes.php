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

// services
Route::get('/getAllServices/{length?}', 'ServicesController@getAllServices');
Route::post('/AddService', 'ServicesController@store');
Route::get('/MyServices/{length?}', 'ServicesController@MyServices');
Route::get('/service/{id}', 'ServicesController@getServiceById');
Route::get('/getUserServices/{id}/{length?}', 'ServicesController@getUserServices');
Route::get('/CategoryServices/{id}/{length?}', 'CategoryController@CategoryServices');
Route::get('/getAllCategories', 'CategoryController@getAllCategories');

// orders
Route::get('/AddOrder/{id}', 'OrdersController@AddOrder');
Route::get('/getMyPurchaseOrders', 'OrdersController@getMyPurchaseOrders');
Route::get('/getMyIncomeOrders', 'OrdersController@getMyIncomeOrders');
Route::get('/GetOrderById/{id}', 'OrdersController@GetOrderById');
Route::get('/ChangeStatus/{id}/{status}', 'OrdersController@ChangeStatus');
Route::get('/finishOrder/{id}/{status}', 'OrdersController@finishOrder');

// comments
Route::post('/AddComment', 'CommentsController@AddComment');
Route::get('/getAllComments/{id}', 'CommentsController@getAllComments');

// messages
Route::post('/SendMessage', 'MessagesController@SendMessage')->middleware('auth');
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
Route::post('/AddCreditNow', 'PaypalController@AddCreditNow')->middleware('auth');
Route::get('/getAllCharges', 'UserController@getAllCharges')->middleware('auth');
Route::get('/getAllpayments', 'UserController@getAllpayments')->middleware('auth');
Route::get('/Profits', 'UserController@Profits')->middleware('auth');
Route::get('/getAllBalance', 'UserController@getAllBalance')->middleware('auth');

// notifications
Route::get('/getUserNotifications/{length?}', 'UserController@getUserNotifications')->middleware('auth');
Route::get('/getNotificationList', 'UserController@getNotificationList')->middleware('auth');


//
