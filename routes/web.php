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

$app->get('/', function () use ($app) {
    $user = User::find(8);

    $vk = new VK(env('VK_APP_ID'), env('VK_API_SECRET'), $user->access_token);

    $vk->setApiVersion(5.64);

    return $vk->api('newsfeed.get', [
        'filters' => 'post',
        'count' => 3,
    ])['response']['items'];
});

$app->get('login/{telegram_id}', [
    'as' => 'login', 'uses' => 'LoginController@login'
]);

$app->get('callback/{telegram_id}', [
    'as' => 'callback', 'uses' => 'LoginController@callback'
]);
