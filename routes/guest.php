<?php

Route::get('register2', [
    'uses' => 'RegisterController2@create',
    'as' => 'register2'
]);

Route::post('register2', [
    'uses' => 'RegisterController2@store',
]);