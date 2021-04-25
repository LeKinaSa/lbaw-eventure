<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home
Route::view('/', 'pages.home');

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('/sign-in', 'Auth\LoginController@showLoginForm')->name('sign-in');
Route::post('/sign-in', 'Auth\LoginController@login');
Route::get('/sign-out', 'Auth\LoginController@logout')->name('sign-out');
Route::get('/sign-up', 'Auth\RegisterController@showRegistrationForm')->name('sign-up');
Route::post('/sign-up', 'Auth\RegisterController@register');
