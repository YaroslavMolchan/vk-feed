<?php

namespace App\Dto\Attachments;

class Link {

    /**
     * Link constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        $this->url = $attributes['url'];
        $this->caption = $attributes['title'];
    }
}