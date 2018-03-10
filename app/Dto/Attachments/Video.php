<?php

namespace App\Dto\Attachments;

class Video {

    /**
     * Video constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        $this->video = 'https://vk.com/video' . $attributes['owner_id'] . '_' . $attributes['id'];
        $this->caption = $attributes['text'];
    }
}