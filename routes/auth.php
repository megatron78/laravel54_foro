<?php
/**
 * Created by PhpStorm.
 * User: Mauricio Molina
 * Date: 2017-05-11
 * Time: 10:16
 */
//Routes that require authentication

//Post
Route::get('posts/create', [
    'uses' => 'CreatePostController@create',
    'as' => 'posts.create']);

Route::post('posts/create', [
    'uses' => 'CreatePostController@store',
    'as' => 'posts.store'
]);

//Comments
Route::post('posts/{post}/comment/create', [
    'uses' => 'CommentController@store',
    'as' => 'comments.store',
]);

Route::post('comments/{comment}/accept', [
    'uses' => 'CommentController@accept',
    'as' => 'comments.accept',
]);

Route::post('posts/{post}/subscribe' , [
    'uses' => 'SubscriptionController@subscribe',
    'as' => 'posts.subscribe'
]);

Route::delete('posts/{post}/unsubscribe' , [
    'uses' => 'SubscriptionController@unsubscribe',
    'as' => 'posts.unsubscribe'
]);