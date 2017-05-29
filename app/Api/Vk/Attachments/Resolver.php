<?php

namespace App\Api\Vk\Attachments;

use App\Api\Vk\Attachments\Types\BaseType;
use App\Api\Vk\Attachments\Types\Dummy;

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
        try {
            return new $className($raw[$raw['type']]);
        }
        catch (\Exception $e) {
            return new Dummy($raw[$raw['type']]);
        }
    }
}