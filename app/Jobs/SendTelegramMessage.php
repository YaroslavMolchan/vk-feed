<?php

namespace App\Jobs;

use App\Dto\Messages\DocumentMessage;
use App\Dto\Messages\Message;
use App\Dto\Messages\PhotoMessage;
use App\Dto\Messages\TextMessage;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;

class SendTelegramMessage extends Job
{
    /**
     * @var Message
     */
    private $message;

    /**
     * Create a new job instance.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $bot = new BotApi(env('TELEGRAM_BOT_API'));

//        try {
            if (get_class($this->message) === TextMessage::class) {
                $bot->sendMessage(
                    $this->message->id,
                    $this->message->text,
                    $this->message->parseMode,
                    $this->message->disablePreview
                );
            } elseif (get_class($this->message) === PhotoMessage::class) {
                $bot->sendPhoto(
                    $this->message->id,
                    $this->message->photo,
                    $this->message->caption
                );
            } elseif (get_class($this->message) === DocumentMessage::class) {
                $bot->sendDocument(
                    $this->message->id,
                    $this->message->document,
                    $this->message->caption
                );
            }
//        } catch (Exception $exception) {
            // Что-то пошло не так, но пользователю не обязательно об этом знать, это всего лишь пост со стены.
//        }
    }
}
