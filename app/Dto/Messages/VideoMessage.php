<?php

namespace App\Dto\Messages;

use App\Dto\Post;

/**
 * Class VideoMessage
 */
class VideoMessage extends Message
{
    /**
     * @var string
     */
    public $video;
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
        /* @var \App\Dto\Attachments\Video $attachment */
        $attachment = $post->attachments->first();
        $this->video = $attachment->video;
        $this->caption = $attachment->caption;
    }
}