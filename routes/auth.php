<?php
/**
 * Created by PhpStorm.
 * User: Mauricio Molina
 * Date: 2017-05-11
 * Time: 10:16
 */
//Routes that require authentication

//Posts
Route::get('posts/create', [
    'uses' => 'CreatePostController@create',
    'as' => 'posts.create']);

Route::post('posts/create', [
    'uses' => 'CreatePostController@store',
    'as' => 'posts.store'
]);