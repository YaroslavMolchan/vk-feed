<?php

namespace App\Dto\Attachments;

class Document {

    /**
     * Document constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        $this->document = $attributes['preview']['video']['src'];
        $this->caption = $attributes['title'];
    }
}