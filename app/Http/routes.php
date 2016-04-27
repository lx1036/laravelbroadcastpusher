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

Route::get('/', function () {
    return 'hello world';
//    return view('welcome');
});

Route::get('/bridge', function () {
    $pusher = \Illuminate\Support\Facades\App::make('pusher');
    $pusher->trigger( 'test-channel',
                    'test-event',
                    ['text' => 'I Love China!!!']);
    return view('welcome');
//    return 'This is a Laravel Pusher Bridge Test!';
});

Route::get('/broadcast', function () {
    event(new \App\Events\PusherEvent('This is a public attribute', '2', 'This is a private attribute', 'This is a protected attribute'));
    return 'This is a Laravel Broadcaster Test, and private/protected attribute is not fired!';
});

Route::controller('notifications', 'NotificationController');
Route::controller('activities', 'ActivityController');
Route::controller('chat', 'ChatController');

Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');