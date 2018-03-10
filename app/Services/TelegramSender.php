<?php

namespace App\Services;

use App\Contracts\SenderInterface;
use App\Dto\Attachments\Document;
use App\Dto\Attachments\Photo;
use App\Dto\Attachments\Video;
use App\Dto\Messages\DocumentMessage;
use App\Dto\Messages\Message;
use App\Dto\Messages\PhotoMessage;
use App\Dto\Messages\TextMessage;
use App\Jobs\SendTelegramMessage;
use App\Support\PostsCollection;
use App\Support\VkPostChecker;
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
//            if ((new VkPostChecker())->passes($post) === false) {
//                continue;
//            }


            if ($post->attachments->count() === 0) {
                $message = new TextMessage($chatId, $post);
                $this->bindJob($message);
            } else {
                $attachment = $post->attachments->first();
                if (get_class($attachment) === Photo::class) {
                    $photo = new PhotoMessage($chatId, $post);
                    if (empty($photo->caption)) {
                        $caption = $post->group . PHP_EOL . $post->text;
                        if (strlen($caption) > 200) {
                            $this->bindJob($photo);
                            $message = new TextMessage($chatId, $post);
                            $this->bindJob($message);
                        } else {
                            $photo->caption = $caption;
                            $this->bindJob($photo);
                        }
                    }
                } elseif (get_class($attachment) === Video::class) {
                    $message = new TextMessage($chatId, $post);
                    $message->text .= PHP_EOL . $attachment->video;
                    $this->bindJob($message);
                } elseif (get_class($attachment) === Document::class) {
                    $message = new DocumentMessage($chatId, $post);
                    $message->caption = strip_tags($post->group) . ':'. $message->caption;
                    $this->bindJob($message);
                }
            }
        }

        return $time;
    }

    /**
     * @author MY
     * @param Message $message
     */
    protected function bindJob(Message $message) {
        // Задержка перед отправкой минимальная, если её не указывать все задачи пойдут паралельно и будет каша.
        $job = new SendTelegramMessage($message);
        dispatch($job);
    }
}