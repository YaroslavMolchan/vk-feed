<?php

namespace App\Dto;

class Post
{
    /**
     * @var string
     */
    public $text;

    /**
     * @var Group
     */
    public $group;

    /**
     * Group constructor.
     *
     * @param array $attributes
     * @param Group $group
     */
    public function __construct(array $attributes, Group $group)
    {
        $this->text = $attributes['text'];
        $this->group = $group;
    }
}
