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

// Authentication
Route::post('login', 'API\Auth\LoginController@authenticate');
Route::post('logout', 'API\Auth\LoginController@logout');
//---------------

// Registration
Route::post('register', 'API\Auth\RegisterController@create');
//-------------

// Projects
Route::group(['prefix' => 'projects'], function () {
    Route::get('/', 'API\ProjectController@index');
    Route::post('/', 'API\ProjectController@store');
    Route::get('/{project_id}', 'API\ProjectController@show');
    Route::put('/{project_id}', 'API\ProjectController@update');
    Route::delete('/{project_id}', 'API\ProjectController@destroy');
});
//---------

// Tasks
Route::group(['prefix' => 'tasks'], function () {
    Route::get('/{task_list_id}', 'API\TaskController@index');
    Route::post('/', 'API\TaskController@store');
});
//------
