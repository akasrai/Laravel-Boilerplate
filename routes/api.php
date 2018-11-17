<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/admin', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function() {
	Route::get('/posts/unique','Myadmin\BlogController@apiCheckUnique')->name('api.posts.unique');
    //Articles rest api link
    Route::get('/admin/blogs','Myadmin\BlogController@getAllBlogs');
    Route::get('admin/article/{id}','Myadmin\ArticleController@show');
    Route::post('admin/article','Myadmin\ArticleController@store');
    Route::put('admin/blog','Myadmin\BlogController@store');
    Route::delete('admin/article/{id}','Myadmin\ArticleController@destroy');
});