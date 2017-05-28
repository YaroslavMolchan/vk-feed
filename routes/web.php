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
"type": "post",
"source_id": -79268570,
"date": 1495995912,
"post_id": 390489,
"post_type": "post",
"text": "&#127481;&#127479;",
"marked_as_ads": 0,
"attachments": [{
"type": "photo",
"photo": {
"id": 456257975,
"album_id": -7,
"owner_id": -79268570,
"user_id": 100,
"photo_75": "https://cs540102....48a/Z5RkXg8aGno.jpg",
"photo_130": "https://cs540102....48b/2vafpoR8w_8.jpg",
"photo_604": "https://cs540102.userapi.com/c836634/v836634931/3098b/PT7D-mWqv_Y.jpg",
"width": 416,
"height": 226,
"text": "",
"date": 1495995912,
"post_id": 390489,
"access_key": "291e022b341063480c"
}
}],
"post_source": {
"type": "vk"
},
"comments": {
"count": 1,
"can_post": 1
},
"likes": {
"count": 14,
"user_likes": 0,
"can_like": 1,
"can_publish": 1
},
"reposts": {
"count": 0,
"user_reposted": 0
},
"views": {
"count": 719
}
}],
"profiles": [],
"groups": [{
"id": 79268570,
"name": "CS:GO HS | Новости Киберспорта",
"screen_name": "csgohs",
"is_closed": 0,
"type": "page",
"is_admin": 0,
"is_member": 1,
"photo_50": "https://pp.userap...691/jrcXKlP4oTw.jpg",
"photo_100": "https://pp.userap...690/5iyFDxQxoAY.jpg",
"photo_200": "https://pp.userap...68f/GfzavOWCcWA.jpg"
}, {
"id": 57876954,
"name": "Vine Video",
"screen_name": "vinevinevine",
"is_closed": 0,
"type": "page",
"is_admin": 0,
"is_member": 1,
"photo_50": "https://pp.userap...57f/xJYWkaRxISI.jpg",
"photo_100": "https://pp.userap...57e/wdH30q7f1sw.jpg",
"photo_200": "https://pp.userap...57d/cVv_Gg7sWQQ.jpg"
}, {
"id": 29058375,
"name": "Zeus Cyber School [CS:GO]",
"screen_name": "zeuscyberschool",
"is_closed": 0,
"type": "page",
"is_admin": 0,
"is_member": 1,
"photo_50": "https://pp.userap...385/sjzhcRYWzpM.jpg",
"photo_100": "https://pp.userap...384/cWTYfCvkb7Q.jpg",
"photo_200": "https://pp.userap...383/UwDMbWj3Ouc.jpg"
}, {
"id": 54026773,
"name": "petr1k",
"screen_name": "petr1k_tv",
"is_closed": 0,
"type": "page",
"is_admin": 0,
"is_member": 0,
"photo_50": "https://pp.userap...f9c/geNs_tK8RGE.jpg",
"photo_100": "https://pp.userap...f9b/I4wXCDDDYd0.jpg",
"photo_200": "https://pp.userap...f9a/1GvUk8kDXpQ.jpg"
}, {
"id": 117306625,
"name": "kENZOR | Official Page",
"screen_name": "kenzorgod",
"is_closed": 0,
"type": "page",
"is_admin": 0,
"is_member": 0,
"photo_50": "https://pp.userap...35c/4jyBTpNQ0Oc.jpg",
"photo_100": "https://pp.userap...35b/ZncxBhvEvDc.jpg",
"photo_200": "https://pp.userap...35a/IupyQvrSwe8.jpg"
}],
"next_from": "1/390489_1495918800_5"
}
}';
$item = json_decode($data, true)['response']['items'][0];
    $post = new \App\Api\Vk\Feed\Types\Post($item);
    $post->prepare();

    $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));
    call_user_func_array([$bot, $post->getMethod()], $post->getParams());
//    $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));env('TELEGRAM_CHAT_ID');
//    $options = [];
//    return call_user_func_array([$bot, $attachment->getMethod()], $options);

//    dd(new \App\Api\Vk\Feed\Types\WallPhoto($item));
//    $user = User::find(1);
//
//    $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'), $user->access_token);
//
//    $vk->setApiVersion(5.64);
//
//    return $vk->api('newsfeed.get', [
//        'filters' => 'post',
//        'count' => 3,
//    ])['response']['items'];
});

$app->get('/test', function () use ($app) {
    $user = User::find(1);
    $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'), $user->access_token);
    $vk->setApiVersion(5.64);

    $response = $vk->api('newsfeed.get', [
        'filters' => 'post',
        'count' => 1,
    ]);

    $feeds = $response['response']['items'];

    $groups = $response['response']['groups'];

    foreach ($feeds as $key => $feed) {
        $post = new \App\Api\Vk\Feed\Types\Post($feed);
        $post->prepare($groups[$key]);

        $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));
        call_user_func_array([$bot, $post->getMethod()], $post->getParams());
    }
});

$app->get('/create', function () use ($app) {
    App\User::create([
        'telegram_id' => env('TELEGRAM_CHAT_ID'),
        'vk_id' => env('VK_ID'),
        'access_token' => env('VK_ACCESS_TOKEN'),
    ]);
});

$app->get('login', [
    'as' => 'login', 'uses' => 'LoginController@login'
]);

$app->get('callback/{telegram_id}/{code}', [
    'as' => 'callback', 'uses' => 'LoginController@callback'
]);
