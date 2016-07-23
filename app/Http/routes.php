<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', function()
{
	return view('home');
}]);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function() {  
    Route::get('/products', ['as' => 'products', 'uses' => 'ProductsController@getIndex']);
    Route::get('/products/search-redirect', ['uses' => 'ProductsController@getSearchRedirect']);
    Route::get('/products/{brand_alias}/{category_alias}', [
        'as' => 'product-search-results', 
        'uses' => 'ProductsController@getSearchResults'
    ]);
    Route::post('/products/send-query', ['uses' => 'ProductsController@postSendQuery']);
       
    Route::get('/cart', ['as' => 'cart', 'uses' => 'CartController@getIndex']);    
    Route::get('/cart/add/{code}', ['as' => 'cart-add', 'uses' => 'CartController@getAdd'])
        ->where('code', '[A-Z\.0-9]+');    
    Route::group(['middleware' => ['ajax']], function() {
        Route::get('/cart/add-ajax/{code}', ['as' => 'cart-add-ajax', 'uses' => 'CartController@getAddAjax'])
            ->where('code', '[A-Z\.0-9]+');
        Route::get('/cart/cart-ajax', ['as' => 'cart-ajax', 'uses' => 'CartController@getCartAjax']);        
    });    
    Route::get('/cart/remove/{rowId}', ['as' => 'cart-remove', 'uses' => 'CartController@getRemove']);
    Route::get('/cart/empty', ['as' => 'cart-empty', 'uses' => 'CartController@getEmpty']);
    Route::post('/cart/submit-order', ['as' => 'cart-submit-order', 'uses' => 'CartController@postSubmitOrder']);
    Route::get('/cart/calculate-shipping/{zipCode}/{dimensions}/{total}', ['as' => 'cart-calculate-shipping', 'uses' => 'CartController@getCalculateShipping']);

    Route::get('/checkout/{result}', ['as' => 'checkout', 'uses' => 'CheckoutController@getIndex'])
        ->where('result', '(success|failure|pending)');

    Route::get('/auth/login', ['as' => 'auth-login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('/auth/login', 'Auth\AuthController@postLogin');    
    Route::get('/auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']); 
    Route::get('/auth/register', ['as' => 'auth-register', 'uses' => 'Auth\AuthController@getRegister']); 
    Route::post('/auth/register', 'Auth\AuthController@postRegister'); 
    Route::get('/auth/registration-successful', ['as' => 'auth-registration-successful', 'uses' => 'Auth\AuthController@getRegistrationSuccessful']); 

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/price-list', ['as' => 'price-list', 'uses' => 'PriceListController@getIndex']);
        Route::get('/price-list/download', ['as' => 'price-list-download', 'uses' => 'PriceListController@getDownload']);
    });

    Route::get('/clients', ['as' => 'clients', function()
    {
        return view('under_construction');
    }]);    

    Route::get('/admin/auth/login', 'Admin\Auth\AuthController@getLogin');       
    Route::post('/admin/auth/login', 'Admin\Auth\AuthController@postLogin');    
    Route::get('/admin/auth/logout', ['as' => 'logout', 'uses' => 'Admin\Auth\AuthController@getLogout']);

    Route::group([
        'namespace' => 'Admin',
        'middleware' => 'auth:admin,/admin/auth/login',
        'prefix' => 'admin'
    ], function() {
        Route::get('/', ['as' => 'welcome', function() {
            return view('admin.welcome');
        }]);
    });    
});