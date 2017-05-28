<?php

namespace App\Api\Vk\Feed\Types;

use App\Api\Vk\Attachments\Resolver;
use App\Api\Vk\Feed\BaseType;

class Post extends BaseType {

    /**
     * находится в записях со стен и содержит текст записи
     * @author MY
     * @var string
     */
    protected $text;

    /**
     * находится в записях со стен, содержит тип новости (post или copy)
     * @author MY
     * @var string
     */
    protected $post_type;

    /**
     * находится в записях со стен, в которых имеется информация о местоположении
     * @author MY
     * @var array
     */
    protected $geo;

    /**
     * находится в записях со стен и содержит массив объектов, которые прикреплены к текущей новости
     * @author MY
     * @link https://vk.com/dev/objects/attachments_w
     * @var array
     */
    protected $attachments;

    /**
     * массив, содержащий историю репостов для записи.
     * @author MY
     * @var BaseType[]
     */
    protected $copy_history;

    /**
     * поле не описано в документации, но и так всё понятно
     * @author MY
     * @var int
     */
    protected $marked_as_ads;

    protected $attributes = [
        'text' => [
            'type' => 'string',
        ],
        'attachments' => [
            'type' => 'array',
            'object' => Resolver::class,
            'method' => 'make'
        ],
    ];

    /**
     * @author MY
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @author MY
     * @param array $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    public function process(array $data)
    {
        echo __CLASS__ . PHP_EOL;
//        var_dump($this->sendData());
    }
}