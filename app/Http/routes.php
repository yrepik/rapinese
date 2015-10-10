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

Route::get('/company', function()
{
	return View::make('company');
});

Route::get('/cv', function()
{
	return View::make('cv');
});
Route::get('/cven', function()
{
	return View::make('cv_en');
});

Route::get('/products/search/{brand}/{category}', ['uses' => 'ProductsController@getSearchResults']);
Route::get('/products/search/{brand}/{category}/pag{page}', ['uses' => 'ProductsController@getSearchResults']);

Route::controller('home', 'HomeController');
Route::controller('products', 'ProductsController');

//Route::get('login', array('uses' => 'AuthController@getLogin'));
