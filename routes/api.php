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

Route::post('login', 'API\Auth\LoginController@authenticate');

// Projects
Route::group(['prefix' => 'projects'], function () {
    Route::get('/', 'API\ProjectController@index');
    Route::post('/', 'API\ProjectController@store');
    Route::get('/{project_id}', 'API\ProjectController@show');
});
//---------

// Tasks
Route::group(['prefix' => 'tasks'], function () {
    Route::get('/{task_list_id}', 'API\TaskController@index');
    Route::post('/', 'API\TaskController@store');
});
//------
