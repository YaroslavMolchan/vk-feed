<?php

namespace App\Dto;

use App\Dto\Attachments\Photo;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Post
{
    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public  $group;

    /**
     * @var int
     */
    public  $date = 0;

    /**
     * @var Collection|null
     */
    public $attachments;

    /**
     * Group constructor.
     *
     * @param array $attributes
     * @param Group $group
     * @throws \InvalidArgumentException
     */
    public function __construct(array $attributes, Group $group)
    {
        $this->group = '<b>' . $group->name . '</b> #' . $group->screen_name;
        $this->attachments = collect();

        if (array_key_exists('text', $attributes) === false) {
            throw new InvalidArgumentException('Key "text" must be present.');
        }
        $this->text  = $attributes['text'];

        if (array_key_exists('date', $attributes) === false) {
            throw new InvalidArgumentException('Key "date" must be present.');
        }
        $this->date  = $attributes['date'];

        if (array_key_exists('marked_as_ads', $attributes) === false) {
            throw new InvalidArgumentException('Key "marked_as_ads" must be present.');
        }

        if (!empty($attributes['attachments'])) {
            foreach ($attributes['attachments'] as $attachment) {
                if ($attachment['type'] == 'photo') {
                    $this->attachments->push(new Photo($attachment['photo']));
                }
            }
        }

        // TODO: Думаю это не стоит тут делать, нужно будет вынести логику вложений с dto.
        //if (\count($attributes['attachments']) > 0) {
            // Берём только первое вложение, обычно в пабликах этого достаточно.
            // TODO: Возможно стоит когда нибудь забирать все вложения и выводить их, в версии 3.5 появилась возможность
            // отправлять альбом картинок или видео.
        //}
    }
}
