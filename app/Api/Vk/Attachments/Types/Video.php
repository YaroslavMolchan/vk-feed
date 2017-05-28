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

    public function __construct(array $raw)
    {
        parent::__construct($raw);

        $this->setParams([
            'text' => 'https://vk.com/video' . $this->owner_id . '_' . $this->id
        ]);
    }
}