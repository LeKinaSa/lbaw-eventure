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
Route::view('/about.php', 'pages.about');
Route::view('/contacts.php', 'pages.contacts');


// User Profile
Route::get('/users/{username}', 'UserController@show')->name('users.profile');
Route::get('/users/{username}/edit', 'UserController@edit')->name('users.profile.edit');
Route::post('/users/{username}/edit', 'UserController@update');
Route::delete('/users/{username}/delete', 'UserController@delete')->name('users.profile.delete');
Route::get('/users/{username}/my-events', 'UserController@showEvents')->name('users.profile.events');

// Event
Route::get('/events/new', 'EventController@create')->name('events.new');
Route::post('/events/new', 'EventController@store');
Route::get('/events/{id}', 'EventController@show')->name('events.event');
Route::get('/events/{id}/edit', 'EventController@edit')->name('events.event.edit');
Route::post('/events/{id}/edit', 'EventController@update');

// TODO: next route is not complete
//Route::get('/events/{id}/matches', 'EventController@show')->name('events.event.matches');
Route::get('/events/{id}/invitations', 'EventController@showInvitations')->name('events.event.invitations');
Route::post('/api/events/{id}/invitations', 'EventController@createInvitation')->name('events.event.invitations.new');
Route::patch('/api/users/{username}/invitations/{idEvent}', 'EventController@updateInvitation')->name('users.user.invitations.update');
Route::delete('/api/events/{id}/invitations/{idUser}', 'EventController@deleteInvitation')->name('events.event.invitations.delete');

Route::delete('/api/events/{id}/invitations', 'EventController@cancelAllInvitations')->name('events.event.invitations.cancel.all');
Route::get('/api/events/{id}/join-request', 'EventController@sendJoinRequest')->name('events.event.joinrequest');
Route::patch('/api/events/{id}/join-request/manage/{idUser}', 'EventController@manageJoinRequest')->name('events.event.joinrequest.manage');
Route::patch('/api/events/{id}/join-request/manage-all', 'EventController@manageAllJoinRequests')->name('events.event.joinrequest.manage.all');

// API
Route::post('/api/events/{id}/polls', 'PollController@store')->name('api.events.event.polls.new');
Route::post('/api/events/{id}/comments', 'CommentController@store')->name('api.events.event.comments.new');
Route::delete('/api/events/{idEvent}/comments/{id}', 'CommentController@destroy')->name('api.events.event.comments.comment.delete');

// Authentication
Route::get('/sign-in', 'Auth\LoginController@showLoginForm')->name('sign-in');
Route::post('/sign-in', 'Auth\LoginController@login');
Route::post('/sign-out', 'Auth\LoginController@logout')->name('sign-out');
Route::get('/sign-up', 'Auth\RegisterController@showRegistrationForm')->name('sign-up');
Route::post('/sign-up', 'Auth\RegisterController@register');
