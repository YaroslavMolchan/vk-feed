<?php

namespace App\Api\Vk\Feed;
use App\Helpers\ChainPattern\Handler;

/**
 * @author MY
 * Class BaseType
 * @link https://vk.com/dev/newsfeed.get
 * @package App\Api\Vk\Feed
 */
class BaseType extends Handler
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

    protected $attributes;

    /**
     * @author MY
     * @var string
     */
    protected $sendMethod;

    /**
     * @author MY
     * @var array
     */
    protected $sendParams;

    /**
     * BaseType constructor.
     * @param array $raw
     */
    public function __construct(array $raw)
    {
        foreach ($this->attributes as $name => $params) {
            if (!array_key_exists($name, $raw)) {
                continue;
            }

            if ($params['type'] != 'array' && $params['type'] != 'object') {
                $this->$name = $raw[$name];
                settype($this->$name, $params['type']);
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
     * @author MY
     * @return string
     */
    public function getSendMethod()
    {
        return $this->sendMethod;
    }

    /**
     * @author MY
     * @param string $sendMethod
     */
    public function setSendMethod($sendMethod)
    {
        $this->sendMethod = $sendMethod;
    }

    /**
     * @author MY
     * @return array
     */
    public function getSendParams()
    {
        return $this->sendParams;
    }

    /**
     * @author MY
     * @param array $sendParams
     */
    public function setSendParams($sendParams)
    {
        $this->sendParams = $sendParams;
    }

    public function sendData()
    {
        return [
            'method' => $this->sendMethod,
            'params' => $this->sendParams
        ];
    }

    /**
     * Processes the request.
     * This is the only method a child can implements,
     * with the constraint to return null to dispatch the request to next successor.
     *
     * @param array $data
     *
     * @return null|mixed
     */
    protected function process(array $data)
    {
        dd($this->sendData());
    }
}