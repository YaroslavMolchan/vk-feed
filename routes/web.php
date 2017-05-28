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

use App\Test\FirstHandler;
use App\Test\SecondHandler;
use App\Test\ThirdHandler;
use App\User;
use VK\VK;

$app->get('/test', function () use ($app) {
    $firstHandler = new FirstHandler();
    $secondHandler = new SecondHandler();
    $thirdHandler = new ThirdHandler();

//the code below sets all successors through the first handler
    $firstHandler->setSuccessor($secondHandler);
    $firstHandler->setSuccessor($thirdHandler);

    $request = 123;
    $result = $firstHandler->handle($request);
    dd($result);
});

$app->get('/', function () use ($app) {

    $data = '{
"response": {
"items": [{
"type": "post",
"source_id": 19555481,
"date": 1495447797,
"post_id": 3497,
"post_type": "post",
"text": "",
"attachments": [{
"type": "link",
"link": {
"url": "http://about.coinkeeper.me/maycontest",
"title": "Подготовьтесь к отпуску!",
"caption": "about.coinkeeper.me",
"description": "Учитывайте финансы в CoinKeeper и выигрывайте призы",
"photo": {
"id": 456239456,
"album_id": -2,
"owner_id": 1321639,
"photo_75": "https://cs7051.us...213/rix46AiPqcI.jpg",
"photo_130": "https://cs7051.us...214/q1eaoDgWRs4.jpg",
"photo_604": "https://cs7051.us...215/Pl1KW-R9D_I.jpg",
"width": 150,
"height": 84,
"text": "",
"date": 1495200930
}
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
},
"views": {
"count": 23
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
"online": 0
}],
"groups": [],
"next_from": "6/3497_1495400400_5"
}
}';
$item = json_decode($data, true)['response']['items'][0];
    $post = new \App\Api\Vk\Feed\Types\Post($item);
//dd($post);
$link = $post->getAttachments()[0];
    $post->setSuccessor($link);
    $photo = $link->getPhoto();
    $post->setSuccessor($photo);

    $result = $post->handle([]);
dd($result);
//    $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));env('TELEGRAM_CHAT_ID');
//    $options = [];
//    return call_user_func_array([$bot, $attachment->getMethod()], $options);

//    dd(new \App\Api\Vk\Feed\Types\WallPhoto($item));
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

$app->get('callback/{telegram_id}', [
    'as' => 'callback', 'uses' => 'LoginController@callback'
]);
