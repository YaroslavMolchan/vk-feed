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

    $data = '{
"response": {
"items": [{
"type": "wall_photo",
"source_id": 213398436,
"date": 1495831862,
"photos": {
"count": 1,
"items": [{
"id": 456240593,
"album_id": -7,
"owner_id": 213398436,
"photo_75": "https://pp.userap...0e0/bUnY2wpsz44.jpg",
"photo_130": "https://pp.userap...0e1/-hgFEMeQ3s8.jpg",
"photo_604": "https://pp.userap...0e2/4Ne1O0z8LYA.jpg",
"width": 292,
"height": 190,
"text": "",
"date": 1495831847,
"post_id": 3292,
"access_key": "4d5a3c130d238ab1b2",
"likes": {
"user_likes": 0,
"count": 0
},
"comments": {
"count": 1
},
"can_comment": 1,
"can_repost": 1
}]
},
"post_id": 1495746000
}],
"profiles": [{
"id": 213398436,
"first_name": "Александр",
"last_name": "Сорокин",
"sex": 2,
"screen_name": "id213398436",
"photo_50": "https://pp.userap...ddd/gVcI47rY8qs.jpg",
"photo_100": "https://pp.userap...ddc/Yj_t90zooxo.jpg",
"online": 1
}],
"groups": [],
"next_from": "1/213398436_1495746000_16"
}
}';

    return json_decode($data, true)['response']['items'];
//    $user = User::find(1);
//
//    $vk = new VK(env('VK_APP_ID'), env('VK_API_SECRET'), $user->access_token);
//
//    $vk->setApiVersion(5.64);
//
//    return $vk->api('newsfeed.get', [
//        'filters' => 'post',
//        'count' => 3,
//    ])['response']['items'];
});

$app->get('login}', [
    'as' => 'login', 'uses' => 'LoginController@login'
]);

$app->get('callback/{telegram_id}', [
    'as' => 'callback', 'uses' => 'LoginController@callback'
]);
