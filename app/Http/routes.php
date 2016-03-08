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
});

Route::get('/clients', ['as' => 'clients', function()
{
	return view('under_construction');
}]);