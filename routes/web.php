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
Route::delete('/users/{username}/delete', 'UserController@delete')->name('users.profile.delete');

// Event
Route::get('/events/new', 'EventController@create')->name('events.new');
Route::post('/events/new', 'EventController@store');
Route::get('/events/{id}', 'EventController@show')->name('events.event');
Route::get('/events/{id}/edit', 'EventController@edit')->name('events.event.edit');
Route::post('/events/{id}/edit', 'EventController@update');

// TODO: next route is not complete
//Route::get('/events/{id}/matches', 'EventController@show')->name('events.event.matches');
Route::get('/events/{id}/invitations', 'EventController@invitations')->name('events.event.invitations');
Route::post('/api/events/{id}/invitations', 'EventController@sendInvitation')->name('events.event.invitations.invite');
Route::delete('/api/events/{id}/invitations/{idInvitation}', 'EventController@cancelInvitation')->name('events.event.invitations.cancel');

// API
Route::post('/api/events/{id}/polls', 'PollController@store')->name('api.events.event.polls.new');

// Authentication
Route::get('/sign-in', 'Auth\LoginController@showLoginForm')->name('sign-in');
Route::post('/sign-in', 'Auth\LoginController@login');
Route::post('/sign-out', 'Auth\LoginController@logout')->name('sign-out');
Route::get('/sign-up', 'Auth\RegisterController@showRegistrationForm')->name('sign-up');
Route::post('/sign-up', 'Auth\RegisterController@register');
