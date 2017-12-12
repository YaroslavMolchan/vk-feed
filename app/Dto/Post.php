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
    public  $group;

    /**
     * @var bool
     */
    public $isAds = false;

    /**
     * @var int
     */
    public $date = 0;

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
        $this->date = $attributes['date'];
        $this->isAds = (bool) $attributes['marked_as_ads'];
    }
}
