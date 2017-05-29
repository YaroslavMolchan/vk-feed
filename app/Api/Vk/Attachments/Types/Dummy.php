<?php

namespace App\Api\Vk\Attachments\Types;

class Dummy extends BaseType {

    protected $attributes = [];

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'sendMessage';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'text' => 'Что-то новое'
        ];
    }
}