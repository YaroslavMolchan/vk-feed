<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Helpers\Vk\Helper;
use App\Helpers\Vk\Messages\Attachments\Doc;
use App\Helpers\Vk\Messages\Attachments\Location;
use App\Helpers\Vk\Messages\Attachments\Video;
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
            $telegram = new BotApi(env('TELEGRAM_BOT_API'));

            $bot = new \TelegramBot\Api\Client('TELEGRAM_BOT_API');

            $bot->command('start', function ($message) use ($bot, $telegram) {
                $chat_id = $message->getChat()->getId();

                $telegram->sendMessage($chat_id, route('home', ['telegram_id' => $chat_id]));
            });

            $bot->on(function($update) use ($telegram){
                $callback = $update->getCallbackQuery();
                $telegram->getSender()->answerCallbackQuery($callback->getId());
            }, function($update){
                return true;
            });

            $bot->run();

        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}