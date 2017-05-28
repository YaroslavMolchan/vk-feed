<?php

namespace App\Api\Vk\Feed\Types;

use App\Api\Vk\Feed\BaseType;

class WallPhoto extends BaseType {

    /**
     * Содержат информацию о количестве объектов и до 5 последних объектов, связанных с данной новостью
     * @author MY
     * @var array
     */
    protected $photos;

    protected $attributes = [
        'type' => [
            'type' => 'string',
        ],
        'source_id' => [
            'type' => 'int'
        ],
        'date' => [
            'type' => 'int'
        ]
    ];

}