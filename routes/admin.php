<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', 'LoginController@showLoginForm')->name('login');;
Route::post('login', 'LoginController@login');

Route::group(['prefix' => 'callback', 'as' => 'callback.', 'namespace' => 'Callback'], function () {
    Route::any('oss/{user}', ['as' => 'oss', 'uses' => 'OssController@index']);
});
Route::group(['middleware' => ['auth:admin']], function () {

    Route::get('/', 'HomeController@index');
    Route::get('logout', 'LoginController@logout');

    Route::group(['middleware' => 'permission:'.config('app.guard.admin')], function () {

        Route::group(['prefix' => 'member', 'as' => 'member.', 'namespace' => 'Member'], function(){
            Route::group(['prefix' => 'manage', 'as' => 'manage.', 'namespace' => 'Manage'], function(){
                Route::get('user', ['as' => 'user', 'uses' => 'UserController@index']);
                Route::get('user/{operate}/{model}', ['as' => 'user.operate', 'uses' => 'UserController@operate']);
                Route::get('callback', ['as' => 'callback', 'uses' => 'CallbackController@index']);
                Route::get('callback/{model}', ['as' => 'callback.info', 'uses' => 'CallbackController@info']);
            });
        });

        Route::group(['prefix' => 'order', 'as' => 'order.', 'namespace' => 'Order'], function(){
            Route::group(['prefix' => 'manage', 'as' => 'manage.', 'namespace' => 'Manage'], function(){
                Route::get('index', ['as' => 'index', 'uses' => 'IndexController@index']);
            });
        });

        Route::group(['prefix' => 'product', 'as' => 'product.', 'namespace' => 'Product'], function(){
            Route::group(['prefix' => 'manage', 'as' => 'manage.', 'namespace' => 'Manage'], function(){
                Route::get('goods', ['as' => 'goods', 'uses' => 'GoodsController@index']);
                Route::any('goods/create/{model?}', ['as' => 'goods.create', 'uses' => 'GoodsController@create']);
                Route::get('goods/delete/{model}', ['as' => 'goods.delete', 'uses' => 'GoodsController@delete']);
                Route::get('goods/skus/{model}', ['as' => 'goods.skus', 'uses' => 'SkusController@index']);
                Route::any('goods/skus/{model}/create/{sku?}', ['as' => 'goods.skus.create', 'uses' => 'SkusController@create']);
                Route::any('goods/skus/delete/{sku?}', ['as' => 'goods.skus.delete', 'uses' => 'SkusController@delete']);
                Route::get('category', ['as' => 'category', 'uses' => 'CategoryController@index']);
                Route::any('category/create/{category?}', ['as' => 'category.create', 'uses' => 'CategoryController@create']);
                Route::get('comment', ['as' => 'comment', 'uses' => 'CommentController@index']);
                Route::get('comment/delete/{model}', ['as' => 'comment.delete', 'uses' => 'CommentController@delete']);
            });
        });

        Route::group(['prefix' => 'system', 'as' => 'system.', 'namespace' => 'System'], function(){
            Route::group(['prefix' => 'develop', 'as' => 'develop.', 'namespace' => 'Develop'], function(){
                Route::get('permission', ['as' => 'permission', 'uses' => 'PermissionController@index']);
                Route::any('permission/create/{permission?}', ['as' => 'permission.create', 'uses' => 'PermissionController@create']);
                Route::get('role', ['as' => 'role', 'uses' => 'RoleController@index']);
                Route::any('role/create/{model?}', ['as' => 'role.create', 'uses' => 'RoleController@create']);
                Route::get('user', ['as' => 'user', 'uses' => 'UserController@index']);
                Route::any('user/create/{model?}', ['as' => 'user.create', 'uses' => 'UserController@create']);
                Route::any('user/passwd/{model}', ['as' => 'user.passwd', 'uses' => 'UserController@passwd']);
                Route::any('user/auth/{model}', ['as' => 'user.auth', 'uses' => 'UserController@auth']);
                Route::any('user/auth/autorole/{model}', ['as' => 'user.auth.autorole', 'uses' => 'UserController@autorole']);
            });

            Route::group(['prefix' => 'base', 'as' => 'base.', 'namespace' => 'Base'], function(){
                Route::any('score', ['as' => 'score', 'uses' => 'ScoreController@index']);
                Route::any('tel', ['as' => 'tel', 'uses' => 'TelController@index']);
                Route::any('banner', ['as' => 'banner', 'uses' => 'BannerController@index']);
                Route::any('poster', ['as' => 'poster', 'uses' => 'BannerController@poster']);
            });

            Route::group(['prefix' => 'alert', 'as' => 'alert.', 'namespace' => 'Alert'], function(){
                Route::get('oss', ['as' => 'oss', 'uses' => 'OssController@index']);
                Route::get('oss/auth', ['as' => 'oss.auth', 'uses' => 'OssController@auth']);
                Route::post('oss/file/{parent}', ['as' => 'oss.file', 'uses' => 'OssController@file']);
                Route::post('oss/mkdir', ['as' => 'oss.mkdir', 'uses' => 'OssController@mkdir']);
            });
        });

    });

});


