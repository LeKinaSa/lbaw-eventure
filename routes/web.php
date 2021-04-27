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

// User Profile
Route::get('/users/{username}', 'UserController@show')->name('users.profile');
Route::get('/users/{username}/edit', 'UserController@edit')->name('users.profile.edit');
Route::post('/users/{username}/edit', 'UserController@update');
/*
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');
*/

// Event
Route::get('/events/{id}', 'EventController@show')->name('events.event');
Route::get('/events/{id}/edit', 'EventController@edit')->name('events.event.edit');
Route::post('/events/{id}/edit', 'EventController@create');
// TODO: do we need a different route to create and edit events?

// TODO: next 2 routes are not complete
Route::get('/events/{id}/matches', 'EventController@show')->name('events.event.matches');
Route::get('/events/{id}/invitations', 'EventController@show')->name('events.event.invitations');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('/sign-in', 'Auth\LoginController@showLoginForm')->name('sign-in');
Route::post('/sign-in', 'Auth\LoginController@login');
Route::post('/sign-out', 'Auth\LoginController@logout')->name('sign-out');
Route::get('/sign-up', 'Auth\RegisterController@showRegistrationForm')->name('sign-up');
Route::post('/sign-up', 'Auth\RegisterController@register');
