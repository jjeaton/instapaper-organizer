<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/list/{folder_id?}', 'BookmarksController@index');
Route::get('/archive/{id}', 'BookmarksController@archive');
Route::get('/delete/{id}', 'BookmarksController@delete');
Route::post('/move/{id}', 'BookmarksController@move');

Route::group(['prefix' => 'ajax'], function () {
	Route::get('archive/{id}', 'BookmarksController@ajaxArchive');
	Route::get('delete/{id}', 'BookmarksController@ajaxDelete');
	Route::post('move/{id}', 'BookmarksController@ajaxMove');
});

Route::get('/folders', 'BookmarksController@folders');
