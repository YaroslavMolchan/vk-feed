<?php

namespace App\Dto\Messages;

use App\Dto\Post;

/**
 * Class PhotoMessage
 */
class PhotoMessage extends Message
{
    /**
     * @var string
     */
    public $photo;
    /**
     * @var string
     */
    public $caption;
    /**
     * @param Post $post
     * @return void
     */
    protected function generateAttributes(Post $post): void
    {
        /* @var \App\Dto\Attachments\Photo $attachment */
        $attachment = $post->attachments->first();
        $this->photo = $attachment->photo;
        $this->caption = $attachment->caption;
    }
}