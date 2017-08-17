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

$app->get('/{$telegram_id?}', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);

$app->get('login', [
    'as' => 'login', 'uses' => 'LoginController@login'
]);

$app->get('callback/{telegram_id}/{code}', [
    'as' => 'callback', 'uses' => 'LoginController@callback'
]);

$app->post('/telegram/webhook', 'TelegramController@webhook');
