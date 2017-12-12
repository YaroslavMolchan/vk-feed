<?php

namespace App\Dto;

use InvalidArgumentException;

class Group
{
    /**
     * @var int
     */
    public $id;

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
     * @throws \InvalidArgumentException
     */
    public function __construct(array $attributes)
    {
        if (array_key_exists('id', $attributes) === false) {
            throw new InvalidArgumentException('Key "id" must be present.');
        }
        $this->id = $attributes['id'];
        if (array_key_exists('name', $attributes) === false) {
            throw new InvalidArgumentException('Key "name" must be present.');
        }
        $this->name = $attributes['name'];
        if (array_key_exists('screen_name', $attributes) === false) {
            throw new InvalidArgumentException('Key "screen_name" must be present.');
        }
        $this->screen_name = $attributes['screen_name'];
    }
}