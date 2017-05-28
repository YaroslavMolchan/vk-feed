<?php

namespace App\Api\Vk\Attachments\Types;

class Link extends BaseType {

    /**
     * URL ссылки
     * @author MY
     * @var string
     */
    protected $url;

    /**
     * заголовок ссылки
     * @author MY
     * @var string
     */
    protected $title;

    /**
     * подпись ссылки (если имеется)
     * @author MY
     * @var string
     */
    protected $caption;

    /**
     * описание ссылки
     * @author MY
     * @var string
     */
    protected $description;

    /**
     * изображение превью, объект фотографии (если имеется)
     * @author MY
     * @var Photo
     */
    protected $photo;

    protected $attributes = [
        'url' => [
            'type' => 'string',
        ],
        'title' => [
            'type' => 'string',
        ],
        'caption' => [
            'type' => 'string',
        ],
        'description' => [
            'type' => 'string',
        ],
        'photo' => [
            'type' => 'object',
            'object' => Photo::class
        ],
    ];

    /**
     * @author MY
     * @return Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        if (!is_null($this->photo)) {
            return $this->photo->getMethod();
        }

        return 'sendMessage';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $text = $this->title . PHP_EOL . $this->description . '. Link: ' . $this->url;

        if (!is_null($this->photo)) {
            return [
                'photo' => $this->photo->getParams()['photo'],
                'caption' => $text
            ];
        }

        return [
            'text' => $text
        ];
    }
}