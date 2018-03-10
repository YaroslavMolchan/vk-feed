<?php

namespace App\Dto\Messages;

use App\Dto\Post;

/**
 * Class DocumentMessage
 */
class DocumentMessage extends Message
{
    /**
     * @var string
     */
    public $document;
    /**
     * @var string
     */
    public $caption;
    /**
     * @param Post $post
     * @return array
     */
    protected function generateAttributes(Post $post): array
    {
        /* @var \App\Dto\Attachments\Document $attachment */
        $attachment = $post->attachments->first();
        $this->document = $attachment->document;
        $this->caption = $attachment->caption;
    }
}