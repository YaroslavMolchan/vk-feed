<?php

namespace App\Services;

use App\Contracts\SenderInterface;
use App\Dto\TelegramMessage;
use App\Jobs\SendTelegramMessage;
use App\Rules\VkPostChecker;
use App\Support\PostsCollection;
use Carbon\Carbon;

class TelegramSender implements SenderInterface
{
    /**
     * @param int             $chatId
     * @param PostsCollection $posts
     *
     * @return int Дата публикации первой записи
     */
    public function sendPosts(int $chatId, PostsCollection $posts): int
    {
        $time = 0;
        /* @var \App\Dto\Post $post */
        foreach ($posts as $index => $post) {
            // Записываем дату первой записи, почему именно первой не помню, но так более точнее получается след. запрос.
            if ($index === 0) {
                $time = $post->date;
            }
            // Проверяем стоит ли нам вообще отправлять эту запись.
            if ((new VkPostChecker())->passes($post) === false) {
                continue;
            }

            // Задержка перед отправкой минимальная, если её не указывать все задачи пойдут паралельно и будет каша.
            $message = new TelegramMessage($chatId, $post);
            $job = (new SendTelegramMessage($message))->delay(Carbon::now()->addSecond());
            dispatch($job);
        }

        return $time;
    }
}