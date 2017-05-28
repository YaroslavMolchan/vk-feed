<?php

namespace App\Api\Vk\Feed\Types;

use App\Api\Vk\Attachments\Resolver;
use App\Api\Vk\Attachments\Types\Doc;
use App\Api\Vk\Attachments\Types\Link;
use App\Api\Vk\Attachments\Types\Photo;
use App\Api\Vk\Attachments\Types\Video;
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
        'source_id' => [
            'type' => 'int',
        ],
        'post_id' => [
            'type' => 'int',
        ],
        'attachments' => [
            'type' => 'array',
            'object' => Resolver::class,
            'method' => 'make'
        ],
    ];

    public function prepare()
    {
        $this->addParam('id', env('TELEGRAM_CHAT_ID'));

        if (count($this->attachments) > 0) {
            $attachment = $this->attachments[0];
            if (get_class($attachment) == Photo::class) {
                $this->setMethod($attachment->getMethod());
                if (!empty($this->text)) {
                    if ($attachment->hasParam('caption')) {
                        $key = 'caption';
                    }
                    elseif ($attachment->hasParam('text')) {
                        $key = 'text';
                    }
                    if (isset($key)) {
                        $link = '🔗 https://vk.com/wall' . $this->source_id . '_' . $this->post_id;
                        $text = $this->text . PHP_EOL . $attachment->getParam($key) . PHP_EOL . $link;
                        $attachment->addParam($key, $text);
                    }
                }
                $this->setParams(array_merge($this->getParams(), $attachment->getParams()));
            }
            elseif (get_class($attachment) == Video::class) {
                $link = '🔗 https://vk.com/wall' . $this->source_id . '_' . $this->post_id;
                $text = $this->text . PHP_EOL . $attachment->getParam('text') . PHP_EOL . $link;
                $this->addParam('text', $text);
            }
            elseif (get_class($attachment) == Doc::class) {
                $link = '🔗 https://vk.com/wall' . $this->source_id . '_' . $this->post_id;
                $text = $this->text . PHP_EOL . $attachment->getParam('text') . PHP_EOL . $link;
                $this->addParam('text', $text);
            }
            else {
                $link = '🔗 https://vk.com/wall' . $this->source_id . '_' . $this->post_id;
                $this->addParam('text', $this->text . PHP_EOL . $link);
            }

//            if (get_class($attachment) == Link::class) {
//                $method = $attachment->senderMethod();
//                $params = $attachment->senderParams();
//                if (!empty($this->senderParams()['text'])) {
//                    if (isset($params['caption'])) {
//                        $params['caption'] = $this->senderParams()['text'] . PHP_EOL . $attachment->senderParams()['caption'];
//                    }
//                    elseif (isset($params['text'])) {
//                        $params['text'] = $this->senderParams()['text'] . PHP_EOL . $attachment->senderParams()['text'];
//                    }
//                }
//            }
        }
        else {
            $link = '🔗 https://vk.com/wall' . $this->source_id . '_' . $this->post_id;
            $this->addParam('text', $this->text . PHP_EOL . $link);
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}