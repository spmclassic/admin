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

//https://learnku.com/articles/10885/full-use-of-jwt#852929
//https://learnku.com/articles/9842/user-role-permission-control-package-laravel-permission-usage-description



Route::post('login', 'LoginController@login');
Route::post('refresh', 'LoginController@refresh');
Route::post('index', 'IndexController@index');
Route::post('callback', 'IndexController@callback');

Route::group(['middleware' => ['jwt.auth']], function ($api) {
    Route::post('category', 'IndexController@category');
    Route::post('logout', 'LoginController@logout');
    Route::post('userinfo', 'LoginController@userinfo');
    Route::post('sign', 'LoginController@sign');
    Route::post('integral', 'IndexController@integral');
    Route::post('integral/delete/{model}', 'IndexController@integralDelete');
    Route::post('tel', 'IndexController@tel');
    Route::post('buy', 'IndexController@buy');
    Route::post('rule', 'IndexController@rule');
    Route::post('clearcatch', 'IndexController@clearcatch');
    Route::post('question', 'IndexController@question');
    Route::post('question2', 'IndexController@question2');
    Route::post('message', 'IndexController@message');
    Route::post('message/change', 'IndexController@changemessage');
    Route::post('message/lists', 'IndexController@mlists');
    Route::post('message/detail/{model}', 'IndexController@dmessage');
    Route::post('goods', 'IndexController@goods');
    Route::post('detail/{model}', 'IndexController@detail');
    Route::post('sku/detail/{model}', 'IndexController@detailsku');
    Route::post('goods/buyed/{model}', 'IndexController@isbuyed');
    Route::post('share/{model}', 'IndexController@share');
    Route::post('pay/{model}', 'IndexController@pay');
    Route::post('saveuserinfo', 'IndexController@saveuserinfo');
});

Route::any('conf/video', function (){
    return request()->all();
});
