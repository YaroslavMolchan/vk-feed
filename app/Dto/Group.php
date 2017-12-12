<?php

namespace App\Dto;

class Group
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $screen_name;

    /**
     * Group constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->name = $attributes['name'];
        $this->screen_name = $attributes['screen_name'];
    }
}