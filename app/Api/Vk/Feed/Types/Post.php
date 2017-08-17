<?php

namespace App\Api\Vk\Feed\Types;

use App\Api\Vk\Attachments\Resolver;
use App\Api\Vk\Attachments\Types\Doc;
use App\Api\Vk\Attachments\Types\Link;
use App\Api\Vk\Attachments\Types\Photo;
use App\Api\Vk\Attachments\Types\Video;
use App\Api\Vk\Feed\BaseType;
use App\Group;
use App\Jobs\TransferFeedJob;
use Carbon\Carbon;

class Post extends BaseType
{

    /**
     * находится в записях со стен и содержит текст записи
     *
     * @author MY
     * @var string
     */
    protected $text;

    /**
     * находится в записях со стен, содержит тип новости (post или copy)
     *
     * @author MY
     * @var string
     */
    protected $post_type;

    /**
     * находится в записях со стен, в которых имеется информация о местоположении
     *
     * @author MY
     * @var array
     */
    protected $geo;

    /**
     * находится в записях со стен и содержит массив объектов, которые прикреплены к текущей новости
     *
     * @author MY
     * @link https://vk.com/dev/objects/attachments_w
     * @var array
     */
    protected $attachments;

    /**
     * время публикации новости в формате unixtime
     *
     * @author MY
     * @var int
     */
    protected $date;

    /**
     * массив, содержащий историю репостов для записи.
     *
     * @author MY
     * @var BaseType[]
     */
    protected $copy_history;

    /**
     * поле не описано в документации, но и так всё понятно
     *
     * @author MY
     * @var int
     */
    protected $marked_as_ads;

    protected $attributes = [
        'text'          => [
            'type' => 'string',
        ],
        'source_id'     => [
            'type' => 'int'
        ],
        'post_id'       => [
            'type' => 'int',
        ],
        'date'          => [
            'type' => 'int',
        ],
        'marked_as_ads' => [
            'type' => 'int',
        ],
        'attachments'   => [
            'type'   => 'array',
            'object' => Resolver::class,
            'method' => 'make'
        ],
    ];

    protected $sender_queue = [];

    /**
     * @author MY
     * @return array
     */
    public function prepare()
    {
        //Пропускаем рекламу
        if ($this->isAds()) {
            return [
                'is_send' => false,
                'date'    => ++$this->date
            ];
        }

        $this->addParam('id', env('TELEGRAM_CHAT_ID'));
        $group = $this->groups->where('id', abs($this->source_id))->first();

        $group_name = '<b>' . $group['name'] . '</b> #' . $group['screen_name'] . PHP_EOL;
        $text       = $group_name . $this->text;

        if (count($this->attachments) > 0) {
            $attachment = $this->attachments[0];
            if (get_class($attachment) == Photo::class) {
                if (!empty($this->text)) {
                    if (strlen($text) < 200) {
                        $this->setMethod($attachment->getMethod());
                        $attachment->addParam('caption', $group['name'] . PHP_EOL . $this->text);

                        $job = (new TransferFeedJob($this->getMethod(), [
                            env('TELEGRAM_CHAT_ID'),
                            $attachment->getParam('photo'),
                            $attachment->getParam('caption')
                        ]))->delay(Carbon::now()->addSecond());
                        dispatch($job);
                    } else {
                        //Паблик Подслушано отправляет разделитель в виде картинки, его не постим
                        if ($this->isSourceNeedToSkip()) {
                            dispatch(new TransferFeedJob($attachment->getMethod(), [
                                env('TELEGRAM_CHAT_ID'),
                                $attachment->getParam('photo')
                            ]));
                        }

                        dispatch(new TransferFeedJob($this->getMethod(), [
                            env('TELEGRAM_CHAT_ID'),
                            $text,
                            'HTML',
                            true
                        ]));
                    }

                    return [
                        'is_send' => false,
                        'date'    => ++$this->date
                    ];
                }
                $attachment->addParam('caption', $group['name'] . ' #' . $group['screen_name']);
                $this->setMethod($attachment->getMethod());
                $this->setParams(array_merge($this->getParams(), $attachment->getParams()));
            } elseif (get_class($attachment) == Video::class) {
                $text = '<b>' . $group['name'] . '</b>' . PHP_EOL . $this->text . PHP_EOL . $attachment->getParam('text');
                $this->addParam('text', $text);
            } elseif (get_class($attachment) == Doc::class) {
                $this->setMethod($attachment->getMethod());
                $attachment->addParam('caption', $group['name'] . ' #' . $group['screen_name'] . ': ' . $this->text);
                $this->setParams(array_merge($this->getParams(), $attachment->getParams()));

                return [
                    'is_send' => true,
                    'date'    => ++$this->date
                ];
            } elseif (get_class($attachment) == Link::class) {
                // Пропускаем посты с ссылками, позже может реализую вывод ссылки
                return [
                    'is_send' => false,
                    'date'    => ++$this->date
                ];
            } else {
                $this->addParam('text', $group['name'] . PHP_EOL . $this->text);
            }

            $this->addParam('parseMode', 'HTML');
        } else {
            $this->addParam('text', $group_name . $this->text);
            $this->addParam('parseMode', 'HTML');
            $this->addParam('disable_preview', true);
        }

        return [
            'is_send' => true,
            'date'    => ++$this->date
        ];
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

    /**
     * @return bool
     */
    protected function isAds()
    {
        return $this->marked_as_ads == 1;
    }

    /**
     * @return bool
     */
    protected function isSourceNeedToSkip()
    {
        return $this->source_id != -34215577;
    }
}