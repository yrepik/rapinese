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

    Route::group(['middleware' => ['cart_count']], function() {
        Route::get('/', ['as' => 'home', function()
        {
            return view('home');
        }]);

        Route::get('/productos', ['as' => 'products', 'uses' => 'ProductsController@index']);
        Route::post('/productos/search-redirect', ['uses' => 'ProductsController@searchRedirect']);
        Route::get('/productos/{brand_alias}/{category_alias}', [
            'as' => 'product-search-results',
            'uses' => 'ProductsController@searchResults'
        ]);
        Route::post('/products/send-query', ['uses' => 'ProductsController@sendQuery']);

        Route::get('/carrito', ['as' => 'cart', 'uses' => 'CartController@index']);
        Route::get('/carrito/agregar/{code}', ['as' => 'cart-add', 'uses' => 'CartController@addItem'])
            ->where('code', '[A-Z\.0-9]+');
        Route::group(['middleware' => ['wants_json']], function() {
            Route::get('/carrito/agregar-ajax/{code}', ['as' => 'cart-add-ajax', 'uses' => 'CartController@addItemAjax'])
                ->where('code', '[A-Z\.0-9]+');
            Route::get('/carrito/carrito-ajax', ['as' => 'cart-ajax', 'uses' => 'CartController@getCartAjax']);
            Route::post('/carrito/calcular-envio', ['as' => 'cart-calculate-shipping', 'uses' => 'CartController@calculateShipping']);
        });
        Route::get('/carrito/quitar/{rowId}', ['as' => 'cart-remove', 'uses' => 'CartController@removeItem']);
        Route::get('/carrito/vaciar', ['as' => 'cart-empty', 'uses' => 'CartController@emptyCart']);
        Route::post('/carrito/enviar-orden', ['as' => 'cart-submit-order', 'uses' => 'CartController@submitOrder']);

        Route::get('/checkout/{result}', ['as' => 'checkout', 'uses' => 'CheckoutController@index'])
            ->where('result', '(success|failure|pending)');

        Route::get('/auth/login', ['as' => 'auth-login', 'uses' => 'Auth\AuthController@getLogin']);
        Route::post('/auth/login', 'Auth\AuthController@postLogin');
        Route::get('/auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
        Route::get('/auth/register', ['as' => 'auth-register', 'uses' => 'Auth\AuthController@getRegister']);
        Route::post('/auth/register', 'Auth\AuthController@postRegister');
        Route::get('/auth/registration-successful', ['as' => 'auth-registration-successful', 'uses' => 'Auth\AuthController@getRegistrationSuccessful']);

        Route::group(['middleware' => 'auth'], function () {
            Route::get('/lista-de-precios', ['as' => 'price-list', 'uses' => 'PriceListController@getIndex']);
            Route::get('/lista-de-precios/descargar', ['as' => 'price-list-download', 'uses' => 'PriceListController@getDownload']);
        });

        Route::get('/clients', ['as' => 'clients', function()
        {
            return view('under_construction');
        }]);
    });

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
