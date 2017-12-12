<?php

namespace App\Dto;

use InvalidArgumentException;

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
     * @throws \InvalidArgumentException
     */
    public function __construct(array $attributes, Group $group)
    {
        $this->group = $group;

        if (array_key_exists('text', $attributes) === false) {
            throw new InvalidArgumentException('Key "text" must be present.');
        }
        $this->text  = $attributes['text'];

        if (array_key_exists('date', $attributes) === false) {
            throw new InvalidArgumentException('Key "date" must be present.');
        }
        $this->date  = $attributes['date'];

        if (array_key_exists('marked_as_ads', $attributes) === false) {
            throw new InvalidArgumentException('Key "marked_as_ads" must be present.');
        }
        $this->isAds = (bool) $attributes['marked_as_ads'];
    }
}
