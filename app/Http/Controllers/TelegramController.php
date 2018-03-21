<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Helpers\Vk\Helper;
use App\Helpers\Vk\Messages\Attachments\Doc;
use App\Helpers\Vk\Messages\Attachments\Location;
use App\Helpers\Vk\Messages\Attachments\Video;
use App\Repositories\UserRepository;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\Types\Update;
use VK\VK;

class TelegramController extends Controller
{
    public function webhook()
    {
        try {
            $repository = app()->make(UserRepository::class);

            $telegram = new BotApi(env('TELEGRAM_BOT_API'));

            $bot = new \TelegramBot\Api\Client('TELEGRAM_BOT_API');

            $bot->command('start', function ($message) use ($telegram) {
                $chatId = $message->getChat()->getId();

                $telegram->sendMessage($chatId, route('home', ['telegram_id' => $chatId]));
            });

            $bot->command('enable', function ($message) use ($telegram, $repository) {
                $chatId = $message->getChat()->getId();

                $user = $repository->findByTelegramId($chatId);

                if (null === $user) {
                    $telegram->sendMessage($chatId, 'You are not connected to bot.');
                } else {
                    $user->enable();

                    $telegram->sendMessage($chatId, 'News Feed enabled, to disable type: /disable');
                }
            });

            $bot->command('disable', function ($message) use ($telegram, $repository) {
                $chatId = $message->getChat()->getId();

                $user = $repository->findByTelegramId($chatId);

                if (null === $user) {
                    $telegram->sendMessage($chatId, 'You are not connected to bot.');
                } else {
                    $user->disable();

                    $telegram->sendMessage($chatId, 'News Feed disabled, to enable type: /enable');
                }
            });

            // Стандартный ответ для бота.
            $bot->on(function($update) use ($telegram){
                $callback = $update->getCallbackQuery();
                $telegram->answerCallbackQuery($callback->getId());
            }, function($update){
                return true;
            });

            $bot->run();

        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}