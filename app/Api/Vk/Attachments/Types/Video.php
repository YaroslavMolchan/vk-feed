<?php

namespace App\Api\Vk\Attachments\Types;

class Video extends BaseType {

    /**
     * идентификатор видеозаписи
     * @var int
     */
    protected $id;

    /**
     * идентификатор владельца видеозаписи
     * @var int
     */
    protected $owner_id;

    protected $attributes = [
        'id' => [
            'type' => 'int',
        ],
        'owner_id' => [
            'type' => 'int',
        ]
    ];

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
            'text' => 'https://vk.com/video' . $this->owner_id . '_' . $this->id,
        ];
    }
}