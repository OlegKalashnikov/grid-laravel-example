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

Route::get('/', ['uses' => 'UsersController@index']);
Route::get('/users.json', ['uses' => 'UsersController@gridData', 'as' => 'users.json']);
Route::get('/users.csv', ['uses' => 'UsersController@gridCsv', 'as' => 'users.csv']);
