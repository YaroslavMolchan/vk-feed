<?php

namespace App\Api\Vk\Attachments\Types;

class Doc extends BaseType {

    /**
     * идентификатор документа
     * @var int
     */
    protected $id;

    /**
     * название документа
     * @var string
     */
    protected $title;

    /**
     * адрес документа, по которому его можно загрузить
     * @var string
     */
    protected $url;

    protected $attributes = [
        'id' => [
            'type' => 'int',
        ],
        'title' => [
            'type' => 'string',
        ],
        'url' => [
            'type' => 'string',
        ]
    ];

    public function __construct(array $raw)
    {
        parent::__construct($raw);

        $this->setParams([
            'text' => $this->title . PHP_EOL . $this->url
        ]);
    }
}