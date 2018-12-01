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

Route::group([
    'as'            => 'larachatter.',
    'namespace'     => '\Launcher\Larachatter\Http\Controllers',
    'middleware'    => [
        'web',
        'auth',
    ],
], function () {

    // Home page
    Route::get('/messages', function () {
        return View('larachatter::larachatter');
    })->name('home');

    // User profile
    Route::get('/profile/refresh', 'ProfileController@refresh');
    Route::get('/profile/notifications', 'ProfileController@notifications');
    Route::post('/profile', 'ProfileController@update');

    // Conversations
    Route::get('/conversations', 'ConversationsController@index');
    Route::post('/conversations/{receiver}', 'ConversationsController@show');
    Route::delete('/conversations/{receiver}', 'ConversationsController@destroy');

    // Messages
    Route::post('/messages', 'MessagesController@send');
    Route::delete('/messages/{id}', 'MessagesController@destroy');

    // Locate Receivers
    Route::post('/receivers', 'ReceiversController@search');

    // Example page
    Route::get('/notification-page-sample', function () {
        return View('larachatter::example');
    })->name('example');
});
