<?php

use Illuminate\Http\Request;


use App\Task;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function(){
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::get('me', 'MeController');
});


Route::get('tasks', 'Api\TaskController@index');
Route::get('tasks/{id}', 'Api\TaskController@show');
Route::post('tasks', 'Api\TaskController@uploadImage');

Route::get('trackings', 'Api\TaskTrackingController@index');
Route::get('trackings/{id}', 'Api\TaskTrackingController@show');

Route::get('jargons/{title}', 'Api\JargonController@getByTitle');

Route::group(['prefix' => 'search'], function(){
    Route::post('user-search', 'Api\SearchController@userSearch');
    Route::post('user-choice', 'Api\SearchController@userChoice');
    Route::post('history-choice', 'Api\SearchController@historyChoice');
});

Route::apiResource('tasks', 'Api\TaskController')->only(['index', 'show']);