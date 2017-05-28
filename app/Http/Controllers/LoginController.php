<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginCallbackException;
use App\User;
use Illuminate\Http\Request;
use VK\VK;
use VK\VKException;

class LoginController extends Controller
{
    public function login()
    {
        $vk = new VK(env('VK_APP_ID'), env('VK_API_SECRET'));

        return redirect()->to($vk->getAuthorizeURL('wall,friends,offline')); //, route('callback', ['telegram_id' => $telegram_id])
    }

    public function callback($telegram_id, $code)
    {
        $vk = new VK(env('VK_APP_ID'), env('VK_API_SECRET'));

        if (is_null($code)) {
            throw new LoginCallbackException('Wrong URL, try to authorize again.');
        }

        try {
            $response = $vk->getAccessToken($code); //, route('callback', ['telegram_id' => $telegram_id])
        } catch (VKException $e) {
            throw new LoginCallbackException('Code expired, try to authorize again.');
        }

        if (User::whereTelegramId($telegram_id)->count() > 0) {
            throw new LoginCallbackException('You are already connected to bot.');
        }

        /**
         * Может быть 2 случая: когда он уже подключился с другого телефона или с другого чата написал.
         */
        if (User::whereVkId($response['user_id'])->count() > 0) {
            throw new LoginCallbackException('You ate already connected to bot from another number.');
        }

        $user = User::create([
            'vk_id' => $response['user_id'],
            'access_token' => $response['access_token'],
            'telegram_id' => $telegram_id
        ]);

        return 'Now you connected to bot';
    }
}
