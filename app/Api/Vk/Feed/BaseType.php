<?php

namespace App\Api\Vk\Feed;

use App\Api\Vk\Feed\Types\Point;

/**
 * @author MY
 * Class BaseType
 * @link https://vk.com/dev/newsfeed.get
 * @package App\Api\Vk\Feed
 */
class BaseType
{

    /**
     * тип списка новости, соответствующий одному из значений параметра filters
     * @author MY
     * @var string
     */
    protected $type;

    /**
     * идентификатор источника новости (положительный — новость пользователя, отрицательный — новость группы)
     * @author MY
     * @var int
     */
    protected $source_id;

    /**
     * время публикации новости в формате unixtime
     * @author MY
     * @var int
     */
    protected $date;

    /**
     * находится в записях со стен и содержит текст записи
     * @author MY
     * @var string
     */
    protected $text;

    /**
     * находится в записях со стен и содержит массив объектов, которые прикреплены к текущей новости
     * @author MY
     * @link https://vk.com/dev/objects/attachments_w
     * @var array
     */
    protected $attachments;

    /**
     * находится в записях со стен, в которых имеется информация о местоположении
     * @author MY
     * @var array
     */
    protected $geo;

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
        'type' => true,
        'source_id' => true,
        'date' => true,
        'text' => true,
        'attachments' => [],
        'geo' => Point::class,
        'copy_history' => [],
        'marked_as_ads' => true
    ];

    /**
     * BaseType constructor.
     * @param array $raw
     */
    public function __construct(array $raw)
    {
        foreach ($this->attributes as $name => $type) {
            if (!array_key_exists($name, $raw)) {
                continue;
            }

            if (is_bool($type)) {
                $this->$name = $raw[$name];
            } elseif (is_string($type)) {
                $this->name = new $type($raw[$name]);
            } elseif (is_array($type)) {
                foreach ($raw[$name] as $item) {
                    //todo: нужно передавать что будет в массиве и обрабатывать
                    array_push($this->$name, $item);
                }
            }
        }
    }
}