<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('users', 'UsersController', ['only' => 'show']);

Route::get('knowledges/search/{location}', 'KnowledgesController@search')->name('knowledges.search');
Route::get('knowledges/type/{location}', 'KnowledgesController@type')->name('knowledges.type');

Route::resource('knowledges', 'KnowledgesController', ['only' => ['store', 'show']]);