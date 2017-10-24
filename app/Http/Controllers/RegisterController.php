<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginCallbackException;
use App\User;
use Illuminate\Http\Request;
use VK\VK;
use VK\VKException;

/**
 * Class: RegisterController
 */
class RegisterController extends Controller
{
    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        $this->validate($request, [
            'telegram_id' => 'required|exists:users,telegram_id',
            'code'        => 'required'
        ]);

        $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'));

        // if (is_null($code)) {
        //     throw new LoginCallbackException('Wrong URL, try to authorize again.');
        // }

        try {
            $response = $vk->getAccessToken($request->input('code')); //, route('callback', ['telegram_id' => $telegram_id])
        } catch (VKException $e) {
            return response()->json([
                'message' => 'Код уже не актуален, получите новый.'
            ], 420);
//            throw new LoginCallbackException('Code expired, try to authorize again.');
        }

        // if (User::whereTelegramId($telegram_id)->count() > 0) {
        //     throw new LoginCallbackException('You are already connected to bot.');
        // }

        /**
         * Может быть 2 случая: когда он уже подключился с другого телефона или с другого чата написал.
         */
        if (User::whereVkId($response['user_id'])->count() > 0) {
            return response()->json([
                'message' => 'Текущий аккаунт VK уже подключен.'
            ], 420);
//            throw new LoginCallbackException('You are already connected to bot from another number.');
        }

        $user = User::create([
            'vk_id'        => $response['user_id'],
            'access_token' => $response['access_token'],
            'telegram_id'  => $request->input('telegram_id')
        ]);

//        return 'Now you connected to bot';
        return response()->json([
            'ok' => true,
            'message' => 'Вы подключились к боту.'
        ]);
    }
}
