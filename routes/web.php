<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



Route::get('/', 'PostController@index');


//Route::controllers(['auth' => 'Auth', 'password' => 'PasswordController']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::group(['prefix' => 'posts'], function(){
        Route::get('', ['as' => 'admin.posts.index', 'uses' =>'PostAdminController@index']);
        Route::get('create', ['as' => 'admin.posts.create', 'uses' => 'PostAdminController@create']);
        Route::post('store', ['as' => 'admin.posts.store', 'uses' => 'PostAdminController@store']);
        Route::get('edit/{id}', ['as' => 'admin.posts.edit', 'uses' => 'PostAdminController@edit']);
        Route::put('update/{id}', ['as' => 'admin.posts.update', 'uses' => 'PostAdminController@update']);
        Route::get('destroy/{id}', ['as' => 'admin.posts.destroy', 'uses' => 'PostAdminController@destroy']);
    });
});


Route::group(['middleware' => ['web']], function(){

    Route::resource('blog', 'BlogController@index');
    Route::get('getItem', 'BlogController@getItem');
    Route::post('/editItem', 'BlogController@editItem');
    Route::post('/addItem', 'BlogController@addItem');
    Route::post('/deleteItem', 'BlogController@deleteItem');

});


