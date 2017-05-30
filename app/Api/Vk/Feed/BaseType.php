<?php

namespace App\Api\Vk\Feed;
use App\Contracts\Vk\SenderInterface;
use Illuminate\Support\Collection;

/**
 * @author MY
 * Class BaseType
 * @link https://vk.com/dev/newsfeed.get
 * @package App\Api\Vk\Feed
 */
class BaseType implements SenderInterface
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
     * находится в записях со стен и содержит идентификатор записи на стене владельца
     * @author MY
     * @var int
     */
    protected $post_id;

    /**
     * время публикации новости в формате unixtime
     * @author MY
     * @var int
     */
    protected $date;

    /**
     * содержит массив объектов сообществ, которые присутствуют в новостях
     * @author MY
     * @var Collection
     */
    protected $groups;

    protected $attributes;

    /**
     * @var string
     */
    protected $method = 'sendMessage';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * BaseType constructor.
     * @param array $raw
     * @param Collection $groups
     */
    public function __construct(array $raw, Collection &$groups)
    {
        $this->groups = $groups;
        foreach ($this->attributes as $name => $params) {
            if (!array_key_exists($name, $raw)) {
                continue;
            }

            if ($params['type'] != 'array' && $params['type'] != 'object') {
                $this->$name = $raw[$name];
                settype($this->$name, $params['type']);
                if (isset($params['function'])) {
                    $this->$name = call_user_func($params['function'], $raw[$name]);
                }
            }
            elseif ($params['type'] == 'array') {
                settype($this->$name, $params['type']);
                foreach ($raw[$name] as $item) {
                    if (!isset($params['method'])) {
                        $class = new $params['object']($item);
                    }
                    else {
                        $class = call_user_func($params['object'] . '::' . $params['method'], $item);
                    }
                    array_push($this->$name, $class);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function hasParam($key)
    {
        return array_key_exists($key, $this->params);
    }

    public function getParam($key)
    {
        if (!$this->hasParam($key)) {
            return null;
        }

        return $this->params[$key];
    }
}