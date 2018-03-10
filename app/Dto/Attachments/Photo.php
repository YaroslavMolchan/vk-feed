<?php

namespace App\Dto\Attachments;

class Photo {

    /**
     * Photo constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        $this->photo = $attributes['photo_604'];
        $this->caption = $attributes['text'];
    }
}