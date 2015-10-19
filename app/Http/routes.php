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

/*Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('/', function()
{
	return View::make('home');
});

Route::get('/products/{brand_alias}/{category_alias}', ['as' => 'product-search-results', 'uses' => 'ProductsController@getSearchResults']);

Route::controller('home', 'HomeController');
Route::controller('products', 'ProductsController');

//Route::get('login', array('uses' => 'AuthController@getLogin'));
