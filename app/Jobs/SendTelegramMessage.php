<?php

namespace App\Jobs;

use App\Dto\TelegramMessage;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;

class SendTelegramMessage extends Job
{
    /**
     * @var TelegramMessage
     */
    private $message;

    /**
     * Create a new job instance.
     *
     * @param TelegramMessage $message
     */
    public function __construct(TelegramMessage $message)
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

        try {
            $bot->sendMessage(
                $this->message->id,
                $this->message->text,
                $this->message->parseMode,
                $this->message->disablePreview
            );
        } catch (Exception $exception) {
            // Что-то пошло не так, но пользователю не обязательно об этом знать, это всего лишь пост со стены.
        }
    }
}
