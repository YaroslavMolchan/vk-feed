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
"source_id": -85687693,
"date": 1496086432,
"post_id": 16,
"post_type": "post",
"text": "ahaha",
"can_edit": 1,
"created_by": 19555481,
"can_delete": 1,
"marked_as_ads": 0,
"attachments": [{
"type": "doc",
"doc": {
"id": 444759448,
"owner_id": 19555481,
"title": "https://vk.com/vinevinevine",
"size": 5410805,
"ext": "gif",
"url": "https://vk.com/doc19555481_444759448?hash=b39aea24d28ae81a21&dl=GE4TKNJVGQ4DC:1496086436:a664aaed3e14953725&api=1&module=feed&no_preview=1",
"date": 1493189006,
"type": 3,
"preview": {
"photo": {
"sizes": [{
"src": "https://cs540102....-3/m_9aacb14ae2.jpg",
"width": 130,
"height": 73,
"type": "m"
}, {
"src": "https://cs540102....-3/s_9aacb14ae2.jpg",
"width": 100,
"height": 57,
"type": "s"
}, {
"src": "https://cs540102....-3/x_9aacb14ae2.jpg",
"width": 604,
"height": 339,
"type": "x"
}, {
"src": "https://cs540102....-3/o_9aacb14ae2.jpg",
"width": 460,
"height": 258,
"type": "o"
}]
},
"video": {
"src": "https://vk.com/doc19555481_444759448?hash=b39aea24d28ae81a21&dl=GE4TKNJVGQ4DC:1496086436:a664aaed3e14953725&api=1&mp4=1&module=feed",
"width": 460,
"height": 258,
"file_size": 406849
}
},
"access_key": "b21118f96c1d37b57d"
}
}],
"post_source": {
"type": "vk"
},
"comments": {
"count": 0,
"can_post": 1
},
"likes": {
"count": 0,
"user_likes": 0,
"can_like": 1,
"can_publish": 1
},
"reposts": {
"count": 0,
"user_reposted": 0
}
}],
"profiles": [{
"id": 19555481,
"first_name": "Ярик",
"last_name": "Молчан",
"sex": 2,
"screen_name": "jadson",
"photo_50": "https://pp.userap...f7e/Z08ZVZE01HU.jpg",
"photo_100": "https://pp.userap...f7d/7ZUtedeR63Q.jpg",
"online": 1
}],
"groups": [{
"id": 85687693,
"name": "WAP Обзор",
"screen_name": "wapobzor",
"is_closed": 0,
"type": "page",
"is_admin": 1,
"admin_level": 3,
"is_member": 1,
"photo_50": "https://pp.userap...47c/ULfjW6qlw5A.jpg",
"photo_100": "https://pp.userap...47b/M2bfU4cgMBQ.jpg",
"photo_200": "https://pp.userap...47a/P5rQ1l49QRQ.jpg"
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
}],
"next_from": "1/16_1496005200_5"
}
}';
$item = json_decode($data, true)['response']['items'][0];
    $post = new \App\Api\Vk\Feed\Types\Post($item);
    $post->prepare(json_decode($data, true)['response']['groups'][0]);

    $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));
//    dd($post->getMethod(), $post->getParams());
//    call_user_func_array([$bot, $post->getMethod()], $post->getParams());
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
    $user = User::where('telegram_id', 67852056)->first();
    $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'), $user->access_token);
    $vk->setApiVersion(5.64);

    $response = $vk->api('newsfeed.get', [
        'filters' => 'post',
        'count' => 100,
        'start_time' => $user->last_date
    ]);

    $feeds = $response['response']['items'];

    $groups = $response['response']['groups'];

    foreach ($feeds as $key => $feed) {
        $post = new \App\Api\Vk\Feed\Types\Post($feed);
        $result = $post->prepare($groups[$key]);

        if ($result['is_send'] == true) {
            $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));
            call_user_func_array([$bot, $post->getMethod()], $post->getParams());
        }
    }

    if (!empty($feeds)) {
        $user->update([
            'last_date' => $result['date']
        ]);
    }

    echo count($feeds) . ' send';
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
