<?php

use Illuminate\Http\Request;
Use App\Fields;
Use App\Processes;
Use App\Tractors;

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

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('fields', 'FieldController@index');
    Route::get('fields/{field}', 'FieldController@show');
    Route::post('fields', 'FieldController@store');
    Route::put('fields/{field}', 'FieldController@update');
    Route::delete('fields/{field}', 'FieldController@delete');
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('tractors', 'TractorController@index');
    Route::get('tractors/{tractor}', 'TractorController@show');
    Route::post('tractors', 'TractorController@store');
    Route::put('tractors/{tractor}', 'TractorController@update');
    Route::delete('tractors/{tractor}', 'TractorController@delete');
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('processes', 'ProcessController@index');
    Route::get('processes/{process}', 'ProcessController@show');
    Route::post('processes', 'ProcessController@store');
    Route::put('processes/{process}', 'ProcessController@update');
    Route::delete('processes/{process}', 'ProcessController@delete');
    Route::put('processes/{process}/approve', 'ProcessController@approveProcess');
});


Route::group(['middleware' => 'auth:api'], function() {
    Route::get('smart-report', 'ReportController@getProcesses');
    Route::get('report', 'ReportBasicController@getProcesses');
});

// Route::middleware('auth:api')->group( function () {
// 	//Route::resource('fields', 'FieldsController');
// 	// Route::apiResource('fields', 'FieldController');
// 	Route::get('fields', 'FieldController@index');
// 	Route::get('fields/{field}', 'FieldController@show');
// 	Route::post('fields', 'FieldController@store');
// 	Route::put('fields/{field}', 'FieldController@update');
// 	Route::delete('fields/{field}', 'FieldController@delete');
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact yazid.erman@gmail.com'], 404);
});

