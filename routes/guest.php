<?php

Route::get('register2/create', [
    'uses' => 'RegisterController2@create',
    'as' => 'register2.create'
]);
Route::post('register2/create', [
    'uses' => 'RegisterController2@store',
    'as' => 'register2.store',
]);
Route::get('token', [
    'uses' => 'TokenController@create',
    'as' => 'token',
]);
Route::post('token', [
    'uses' => 'TokenController@store',
]);
Route::get('token/confirm', [
    'uses' => 'TokenController@confirm',
    'as' => 'token.confirm',
]);
Route::get('ingreso/{token}', [
    'uses' => 'LoginController2@ingreso',
    'as' => 'ingreso',
]);
