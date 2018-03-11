<?php

namespace App\Dto\Attachments;

class Document {
    /**
     * @var string
     */
    public $document;
    /**
     * @var string
     */
    public $caption;

    /**
     * Document constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        if (array_key_exists('preview', $attributes)) {
            $this->document = $attributes['preview']['video']['src'];
        }
        $this->caption = $attributes['title'];
    }
}