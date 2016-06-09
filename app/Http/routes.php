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

Route::get('/', function()
{
	return view('home');
});

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
    Route::get('/price-list', ['as' => 'price-list', 'uses' => 'PriceListController@getIndex']);
    Route::post('/price-list', ['uses' => 'PriceListController@postIndex']);
    Route::get('/price-list/token-sent', ['as' => 'price-list-token-sent', 'uses' => 'PriceListController@getTokenSent']);
    Route::get('/price-list/download/{token}', ['as' => 'price-list-download', 'uses' => 'PriceListController@getDownload'])
        ->where('token', '[A-Za-z0-9]+');
});

Route::get('/clients', ['as' => 'clients', function()
{
	return view('under_construction');
}]);