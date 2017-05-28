<?php

namespace App\Api\Vk\Attachments;

use App\Api\Vk\Attachments\Types\BaseType;

class Resolver {

    /**
     * @author MY
     * Resolver constructor.
     * @param array $raw
     * @throws \Exception
     * @return BaseType
     */
    public static function make(array $raw)
    {
        if (!array_key_exists('type', $raw)) {
            throw new \Exception('Wrong attachment data');
        }

        $className = 'App\Api\Vk\Attachments\Types\\' . ucfirst($raw['type']);
        return new $className($raw[$raw['type']]);
    }
}