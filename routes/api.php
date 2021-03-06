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



Route::group(['middleware' => ['auth:api'], 'namespace'=>'Api'],function(){
    Route::resource('/roles','RoleController');
    Route::post('/roles/create','RoleController@store');
    Route::get('/userlist','UserController@user')->name('userlist');
    Route::get('/verify', function (Request $request) {
    return $request->user();
});
});



Route::post('/login','Api\UserController@login')->name('login');

