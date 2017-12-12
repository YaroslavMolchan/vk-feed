<?php

namespace App\Dto;

/**
 * Class TelegramMessage
 */
class TelegramMessage
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $parseMode      = 'HTML';
    /**
     * @var bool
     */
    public $disablePreview = true;

    /**
     * TelegramMessage constructor.
     *
     * @param int  $chatId
     * @param Post $post
     */
    public function __construct(int $chatId, Post $post)
    {
        $this->id = $chatId;
        $this->text = $this->generateTextContent($post);
    }

    /**
     * @param Post $post
     * @return string
     */
    private function generateTextContent(Post $post): string
    {
        $groupName = '<b>' . $post->group->name . '</b> #' . $post->group->screen_name . PHP_EOL;

        return $groupName . $post->text;
    }
}