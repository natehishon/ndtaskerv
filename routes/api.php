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

Route::get('users', 'Api\UserController@index');
Route::post('users', 'Api\UserController@store');

Route::get('tasks', 'Api\TaskController@index');
Route::get('tasks/{id}', 'Api\TaskController@show');
Route::post('tasks/{id}', 'Api\TaskController@update');
Route::post('tasks', 'Api\TaskController@store');

Route::get('folders/{name}', 'Api\FolderController@folderByName');
Route::get('folders', 'Api\FolderController@index');
Route::post('folders/{id}', 'Api\FolderController@store');
Route::get('user-folders/{id}', 'Api\FolderController@userFolders');
Route::get('prebuilt-folders', 'Api\FolderController@prebuiltFolders');
Route::get('prebuilt-folders/{id}', 'Api\FolderController@getPrebuiltFolder');
Route::post('prebuilt-folders-task/{id}', 'Api\FolderController@storePrebuiltTask');
Route::delete('folders/{id}', 'Api\FolderController@destroy');

Route::get('trackings', 'Api\TaskTrackingController@index');
Route::get('trackings/{id}', 'Api\TaskTrackingController@show');
Route::post('trackings/{id}', 'Api\TaskTrackingController@store');
Route::delete('trackings/{id}', 'Api\TaskTrackingController@destroy');

Route::get('jargons', 'Api\JargonController@index');
Route::get('jargons/{id}', 'Api\JargonController@show');
Route::get('jargons/find/{title}', 'Api\JargonController@getByTitle');
Route::post('jargons/{id}', 'Api\JargonController@update');

Route::post('jargons', 'Api\JargonController@store');

Route::group(['prefix' => 'search'], function(){
    Route::post('user-search', 'Api\SearchController@userSearch');
    Route::post('user-choice', 'Api\SearchController@userChoice');
    Route::post('history-choice', 'Api\SearchController@historyChoice');
});

Route::post('jots', 'Api\JotController@store');
Route::post('jots/{id}', 'Api\JotController@jotComment');
Route::get('jots', 'Api\JotController@index');
Route::get('jots/{id}', 'Api\JotController@show');
Route::get('jots-admin', 'Api\JotController@adminIndex');


Route::apiResource('tasks', 'Api\TaskController')->only(['index', 'show']);
