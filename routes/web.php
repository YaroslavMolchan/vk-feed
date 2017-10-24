<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\User;
use VK\VK;

$app->get('/', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);

$app->get('/telegram/{id}', [
    'as' => 'telegram-redirect', 'uses' => 'HomeController@telegram'
]);

$app->get('user[/{name}]', function ($name = null) {
    return $name;
});

$app->get('login', [
    'as' => 'login', 'uses' => 'LoginController@login'
]);

$app->post('register', [
    'as' => 'register', 'uses' => 'RegisterController@handle'
]);

$app->post('/telegram/webhook', 'TelegramController@webhook');
