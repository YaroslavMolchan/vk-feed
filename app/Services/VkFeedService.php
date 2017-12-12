<?php

namespace App\Services;

use App\Dto\Group;
use App\Dto\Post;
use App\Exceptions\FeedRecordsNotFoundException;
use App\Support\PostsCollection;
use VK\VK;

/**
 * Class VkFeedService
 */
class VkFeedService
{
    /**
     * @var VK
     */
    private $client;

    /**
     * VkFeedService constructor.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->client = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'), $token);
        $this->client->setApiVersion(5.64);
    }

    /**
     * @param int|null $startTime
     * @param int      $count
     * @return PostsCollection
     * @throws FeedRecordsNotFoundException
     */
    public function getPosts(?int $startTime, int $count = 1): PostsCollection
    {
        $response = $this->client->api('newsfeed.get', [
            'filters'    => 'post',
            'count'      => $count,
            'start_time' => $startTime
        ]);

        if (!array_key_exists('response', $response)) {
            throw new FeedRecordsNotFoundException();
        }

        $feeds  = new PostsCollection($response['response']['items']);
        $groups = collect($response['response']['groups']);

        return $feeds->filter(function ($feed) {
            return $this->isRecordPost($feed);
        })->map(function ($feed) use ($groups) {
            $group = $groups->where('id', abs($feed['source_id']))->first();
            return new Post($feed, new Group($group));
        });
    }

    /**
     * @param array $feed
     * @return bool
     */
    public function isRecordPost(array $feed): bool
    {
        return $feed['type'] === 'post';
    }
}