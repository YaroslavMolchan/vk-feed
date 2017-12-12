<?php

namespace App\Contracts;

use App\Support\PostsCollection;

interface SenderInterface
{
    /**
     * @param int             $chatId
     * @param PostsCollection $posts
     *
     * @return int Дата публикации первой записи
     */
    public function sendPosts(int $chatId, PostsCollection $posts): int;
}