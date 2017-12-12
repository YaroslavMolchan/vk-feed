<?php

namespace App\Contracts;

use App\Dto\Post;

interface PostCheckerInterface
{
    /**
     * @param Post $post
     * @return bool
     */
    public function passes(Post $post): bool;
}