<?php

namespace App\Api\Vk\Feed;

/**
 * @author MY
 * Class BaseType
 * @link https://vk.com/dev/newsfeed.get
 * @package App\Api\Vk\Feed
 */
class BaseType {

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
}