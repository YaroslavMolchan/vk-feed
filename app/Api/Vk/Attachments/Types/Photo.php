<?php

namespace App\Api\Vk\Attachments\Types;

class Photo extends BaseType {

    /**
     * текст описания фотографии
     * @author MY
     * @var string
     */
    protected $text;

    /**
     * URL копии фотографии с максимальным размером 604x604px
     * @author MY
     * @var string
     */
    protected $photo_604;

    protected $attributes = [
        'text' => [
            'type' => 'string',
        ],
        'photo_604' => [
            'type' => 'string',
        ]
    ];

    public function process(array $data)
    {
        $this->setSendMethod('photo');
        $this->setSendParams([
            'url' => $this->photo_604
        ]);
        echo __CLASS__ . PHP_EOL;
        return $this->sendData();
    }
}