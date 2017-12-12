<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use VK\VK;
use VK\VKException;

/**
 * Class: RegisterController
 */
class RegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $this->validate($request, [
            'telegram_id' => 'required|exists:users,telegram_id',
            'code'        => 'required'
        ]);

        try {
            $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'));
        } catch (VKException $exception) {
            return response()->json([
                'message' => 'Внутреняя ошибка, повторите попытку позже.'
            ], 500);
        }

        try {
            $response = $vk->getAccessToken($request->input('code'));
        } catch (VKException $e) {
            return response()->json([
                'message' => 'Код уже не актуален, получите новый.'
            ], 420);
        }

        /**
         * Может быть 2 случая: когда он уже подключился с другого телефона или с другого чата написал.
         */
        if ($this->users->checkVkAccount($response['user_id']) === true) {
            return response()->json([
                'message' => 'Текущий аккаунт VK уже подключен.'
            ], 420);
        }

        $this->users->create([
            'vk_id'        => $response['user_id'],
            'access_token' => $response['access_token'],
            'telegram_id'  => $request->input('telegram_id')
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Вы подключились к боту.'
        ]);
    }
}
