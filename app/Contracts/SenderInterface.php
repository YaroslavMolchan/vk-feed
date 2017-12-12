<?php

namespace App\Contracts;

use App\Support\PostsCollection;

interface SenderInterface
{
    /**
     * @param int             $chatId
     * @param PostsCollection $posts
     *
     * @return void
     */
    public function sendPosts(int $chatId, PostsCollection $posts): void;
}