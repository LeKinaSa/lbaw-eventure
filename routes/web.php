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

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home');
Route::view('/about', 'pages.about');
Route::view('/contacts', 'pages.contacts');
Route::view('/faq', 'pages.faq');


// User Profile
Route::get('/users/{username}', 'UserController@show')->name('users.profile');
Route::get('/users/{username}/edit', 'UserController@edit')->name('users.profile.edit');
Route::post('/users/{username}/edit', 'UserController@update');
Route::delete('/users/{username}/delete', 'UserController@delete')->name('users.profile.delete');
Route::get('/users/{username}/my-events', 'UserController@showEvents')->name('users.profile.events');
Route::get('/users/{username}/invitations', 'UserController@showInvitations')->name('users.profile.invitations');

// Event
Route::get('/events/new', 'EventController@create')->name('events.new');
Route::post('/events/new', 'EventController@store');
Route::get('/events/{id}', 'EventController@show')->name('events.event');
Route::get('/events/{id}/edit', 'EventController@edit')->name('events.event.edit');
Route::post('/events/{id}/edit', 'EventController@update');
Route::get('/events/{id}/participants', 'EventController@showParticipants')->name('events.event.participants');
Route::post('/events/{id}/cancel', 'EventController@cancel')->name('events.event.cancel');
Route::post('/events/{id}/delete', 'EventController@destroy')->name('events.event.delete');

// Matches and Competitors
Route::patch('/api/events/{id}/leaderboard-settings', 'EventController@updateLeaderboardSettings')->name('api.events.event.leaderboard-settings.update');
Route::get('/events/{id}/matches', 'EventController@showResults')->name('events.event.matches');
Route::post('/api/events/{id}/matches', 'MatchController@store')->name('api.events.event.matches.new');
Route::get('/events/{id}/matches/competitors', 'CompetitorController@index')->name('events.event.competitors');
Route::post('/api/events/{id}/competitors', 'CompetitorController@store')->name('api.events.event.competitors.new');

// TODO: next route is not complete
//Route::get('/events/{id}/matches', 'EventController@show')->name('events.event.matches');

// Invitations
Route::get('/events/{id}/invitations', 'EventController@showInvitations')->name('events.event.invitations');
Route::post('/api/events/{id}/invitations', 'EventController@createInvitation')->name('events.event.invitations.new');
Route::patch('/api/users/{username}/invitations/{idEvent}', 'EventController@updateInvitation')->name('users.user.invitations.invitation.update');
Route::delete('/api/events/{id}/invitations/{idUser}', 'EventController@deleteInvitation')->name('events.event.invitations.invitation.delete');
Route::delete('/api/events/{id}/invitations', 'EventController@deleteAllInvitations')->name('events.event.invitations.delete');

// Join Requests
Route::post('/api/events/{id}/join-requests', 'EventController@createJoinRequest')->name('events.event.join-requests.new');
Route::patch('/api/events/{id}/join-requests/{idUser}', 'EventController@updateJoinRequest')->name('events.event.join-requests.join-request.update');
Route::patch('/api/events/{id}/join-requests', 'EventController@updateAllJoinRequests')->name('events.event.join-requests.update');

Route::get('/events', 'EventController@showSearchResults')->name('events.search-results');
Route::get('/api/events', 'EventController@getSearchResults')->name('api.events.search-results');

// Polls API
Route::post('/api/events/{id}/polls', 'PollController@store')->name('api.events.event.polls.new');
Route::put('/api/events/{id}/polls/{idPoll}/answer', 'PollController@putAnswer')->name('api.events.event.polls.poll.answer.put');
Route::delete('/api/events/{id}/polls/{idPoll}/answer', 'PollController@deleteAnswer')->name('api.events.event.polls.poll.answer.delete');

// Comments API
Route::post('/api/events/{id}/comments', 'CommentController@store')->name('api.events.event.comments.new');
Route::delete('/api/events/{idEvent}/comments/{id}', 'CommentController@destroy')->name('api.events.event.comments.comment.delete');

// Files API
Route::post('/events/{id}/files', 'FileController@store')->name('events.event.files.new');
Route::get('/events/{id}/files/{fileName}', 'FileController@download')->name('events.event.files.file');

// Authentication
Route::get('/sign-in', 'Auth\LoginController@showLoginForm')->name('sign-in');
Route::post('/sign-in', 'Auth\LoginController@login');
Route::post('/sign-out', 'Auth\LoginController@logout')->name('sign-out');
Route::get('/sign-up', 'Auth\RegisterController@showRegistrationForm')->name('sign-up');
Route::post('/sign-up', 'Auth\RegisterController@register');
Route::get('/forgot-password', 'Auth\ForgotPasswordController@show')->name('password.request');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendEmail')->name('password.email');
Route::get('/reset-password', 'Auth\ForgotPasswordController@showEmailSent')->name('password.email.sent');
Route::get('/recover-password/{token}', 'Auth\ResetPasswordController@show')->name('password.reset');
Route::post('/recover-password', 'Auth\ResetPasswordController@recoverPassword')->name('password.update');

// Administrator authentication
Route::get('/admin/sign-in', 'Auth\AdminLoginController@showLoginForm')->name('admin.sign-in');
Route::post('/admin/sign-in', 'Auth\AdminLoginController@login');
Route::post('/admin/sign-out', 'Auth\AdminLoginController@logout')->name('admin.sign-out');

// Routes exclusive to Administrators
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/user-management', 'AdminController@showUserManagement')->name('admin.user-management');
    Route::post('/api/users/{username}/suspensions', 'SuspensionController@store')->name('api.users.user.suspensions');
    Route::post('/api/users/{username}/ban', 'BannedUserController@store')->name('api.users.user.ban');
});
