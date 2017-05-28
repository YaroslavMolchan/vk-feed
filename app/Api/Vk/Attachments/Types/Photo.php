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

    /**
     * @author MY
     * Photo constructor.
     * @param array $raw
     */
    public function __construct(array $raw)
    {
        parent::__construct($raw);

        $this->setParams([
            'photo' => $this->photo_604,
            'caption' => $this->text
        ]);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'sendPhoto';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}