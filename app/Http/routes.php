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

Route::get('/', function()
{
	return view('home');
});
Route::get('/products', ['as' => 'products', 'uses' => 'ProductsController@getIndex']);
Route::get('/products/search-redirect', ['uses' => 'ProductsController@getSearchRedirect']);
Route::get('/products/{brand_alias}/{category_alias}', [
    'as' => 'product-search-results', 
    'uses' => 'ProductsController@getSearchResults'
]);
Route::get('/clients', ['as' => 'clients', function()
{
	return view('under_construction');
}]);