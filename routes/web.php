<?php

Route::get('/', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);

Route::get('/telegram/{id}', [
    'as' => 'telegram-redirect', 'uses' => 'HomeController@telegram'
]);

Route::get('user[/{name}]', function ($name = null) {
    return $name;
});

Route::get('login', [
    'as' => 'login', 'uses' => 'LoginController@login'
]);

Route::post('register', [
    'as' => 'register', 'uses' => 'RegisterController@handle'
]);

Route::post('/telegram/webhook', 'TelegramController@webhook');