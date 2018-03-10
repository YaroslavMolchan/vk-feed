<?php

namespace App\Dto\Messages;

use App\Dto\Post;

/**
 * Class Message
 */
abstract class Message
{
    /**
     * @var string
     */
    public $type = 'text';
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $parseMode = 'HTML';

    /**
     * Message constructor.
     *
     * @param int  $chatId
     * @param Post $post
     */
    public function __construct(int $chatId, Post $post)
    {
        $this->id   = $chatId;
        $this->generateAttributes($post);
    }

    /**
     * @param Post $post
     * @return array
     */
    abstract protected function generateAttributes(Post $post): array;
}