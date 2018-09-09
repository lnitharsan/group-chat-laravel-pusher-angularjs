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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('groups', 'GroupController@getGroup');
Route::post('groups/create', 'GroupController@store');

Route::get('conversations/{group_id}', 'ConversationController@load');
Route::post('conversations/create', 'ConversationController@store');