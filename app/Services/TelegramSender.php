<?php

namespace App\Services;

use App\Contracts\SenderInterface;
use App\Dto\TelegramMessage;
use App\Jobs\SendTelegramMessage;
use App\Support\PostsCollection;
use Carbon\Carbon;

class TelegramSender implements SenderInterface
{
    /**
     * @param int             $chatId
     * @param PostsCollection $posts
     *
     * @return void
     */
    public function sendPosts(int $chatId, PostsCollection $posts): void
    {
        /* @var \App\Dto\Post $post */
        foreach ($posts as $post) {
            $message = new TelegramMessage($chatId, $post);
            $job = (new SendTelegramMessage($message))->delay(Carbon::now()->addSecond());
            dispatch($job);
        }
    }
}