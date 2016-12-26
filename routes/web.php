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

Route::group([], function() {
    Route::get('/', ['as' => 'home', function()
    {
        return view('home');
    }]);

    Route::get('/productos', 'ProductsController@index')->name('products');
    Route::get('/products', function () {
        return redirect()->route('products', [], 301);
    });
    Route::post('/productos/search-redirect', 'ProductsController@searchRedirect')->name('products-search-redirect');
    Route::get('/productos/{brand_alias}/{category_alias}', 'ProductsController@searchResults')
        ->name('product-search-results');
    Route::get('/products/{brand_alias}/{category_alias}', function ($brandAlias, $categoryAlias) {
        return redirect()->route('product-search-results', [
            'brand_alias' => $brandAlias,
            'category_alias' => $categoryAlias
        ], 301);
    });
    Route::post('/productos/enviar-consulta', 'ProductsController@sendQuery')->name('products-send-query');

    Route::get('/carrito', 'CartController@index')->name('cart');
    Route::get('/cart', function () {
        return redirect()->route('cart', [], 301);
    });
    Route::get('/carrito/agregar/{code}', 'CartController@addItem')->name('cart-add')
        ->where('code', '[A-Z\.0-9]+');
    Route::group(['middleware' => ['wants_json']], function() {
        Route::get('/carrito/agregar-ajax/{code}', 'CartController@addItemAjax')
            ->name('cart-add-ajax')
            ->where('code', '[A-Z\.0-9]+');
        Route::get('/carrito/carrito-ajax', 'CartController@getCartAjax')->name('cart-ajax');
        Route::post('/carrito/calcular-envio', 'CartController@calculateShipping')
            ->name('cart-calculate-shipping');
    });
    Route::get('/carrito/quitar/{rowId}', 'CartController@removeItem')->name('cart-remove');
    Route::get('/carrito/vaciar', 'CartController@emptyCart')->name('cart-empty');
    Route::post('/carrito/enviar-orden', 'CartController@submitOrder')->name('cart-submit-order');

    Route::get('/checkout/{result}', ['as' => 'checkout', 'uses' => 'CheckoutController@index'])
        ->where('result', '(success|failure|pending)');

    Auth::routes();
    Route::get('/logout', 'Auth\LoginController@logout');
    /*Route::get('/auth/login', 'Auth\LoginController@login')->name('auth-login');
    Route::post('/auth/login', 'Auth\LoginController@postLogin');
    Route::get('/auth/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/auth/register', 'Auth\AuthController@getRegister')->name('auth-register');
    Route::post('/auth/register', 'Auth\AuthController@postRegister');
    Route::get('/auth/registration-successful', 'Auth\AuthController@getRegistrationSuccessful')
        ->name('auth-registration-successful');*/

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/lista-de-precios', ['as' => 'price-list', 'uses' => 'PriceListController@getIndex']);
        Route::get('/lista-de-precios/descargar', ['as' => 'price-list-download', 'uses' => 'PriceListController@getDownload']);
    });

    Route::get('/clients', ['as' => 'clients', function()
    {
        return view('under_construction');
    }]);
});

Route::get('/admin/auth/login', 'Admin\Auth\AuthController@showLoginForm')->name('admin-login');
Route::post('/admin/auth/login', 'Admin\Auth\AuthController@login');
Route::get('/admin/auth/logout', 'Admin\Auth\AuthController@logout')->name('admin-logout');

Route::group([
    'namespace' => 'Admin',
    'middleware' => 'auth:admin',
    'prefix' => 'admin'
], function() {
    Route::get('/', ['as' => 'welcome', function() {
        return view('admin.welcome');
    }]);
});
