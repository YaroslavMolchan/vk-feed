<?php

namespace App\Dto\Messages;
use App\Dto\Post;

/**
 * Class TextMessage
 */
class TextMessage extends Message
{
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $disablePreview = true;
    /**
     * @param Post $post
     * @return array
     */
    protected function generateAttributes(Post $post): array
    {
        $this->text = $post->group . PHP_EOL . $post->text;
    }
}