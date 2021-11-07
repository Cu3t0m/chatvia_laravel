<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/chat', 'HomeController@chat');

//Massage
Route::get('/message/{id}', 'HomeController@getMessage')->name('message');
Route::post('message', 'HomeController@sendMessage');
Route::post('typing', 'HomeController@sendTyping');
Route::get('/lastmessage/{id}', 'HomeController@getLastMessage');

//Update avatar
Route::post('/updateavatar', 'UserController@update')->name('updateavatar');

//Update Name
Route::post('/nameupdate', 'UserController@nameupdate')->name('nameupdate');

//Delete Contact
Route::delete('/delete/{id}', 'UserController@destroy')->name('contact.destroy');

//Search Contact
Route::get('/search','UserController@search');

//Search Recent Contact
Route::get('/recentsearch','UserController@recentsearch');

//chat Message Search
Route::get('/messagesearch','UserController@messagesearch');

//Delete Message
Route::get('/deleteMessage/{id}','HomeController@deleteMessage');

// Delete Conversation
Route::get('/deleteConversation/{id}', 'HomeController@deleteConversation')->name('conversation.delete');

//Group Create
Route::post('/groups', 'GroupController@store')->name('groups');

//Group Search
Route::get('/groupsearch','GroupController@groupsearch');

//Group Massage
Route::get('/groupmessage/{id}', 'GroupController@getGroupMessage')->name('groupmessage');
Route::post('groupmessage', 'GroupController@sendGroupMessage');
Route::get('/grouplastmessage/{id}', 'GroupController@getGroupLastMessage');

// Delete Group Message
Route::get('/deletegroupmessage/{id}','GroupController@deletegroupmessage');

// Delete Group Conversation
Route::get('/deleteGroupConversation/{id}', 'GroupController@deleteGroupConversation')->name('groupconversation.delete');

//Group Message Search
Route::get('/groupmessagesearch','GroupController@groupmessagesearch');
