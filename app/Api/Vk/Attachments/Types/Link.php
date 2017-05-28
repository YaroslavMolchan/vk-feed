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
     * @author MY
     * @param Photo $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function process(array $data)
    {
        $this->setSendParams([
            'description' => $this->description
        ]);
        echo __CLASS__ . PHP_EOL;
//        var_dump($this->sendData());
    }
}