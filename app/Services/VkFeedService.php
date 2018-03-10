<?php

namespace App\Services;

use App\Dto\Group;
use App\Dto\Post;
use App\Exceptions\FeedRecordsNotFoundException;
use App\Support\PostsCollection;
use Illuminate\Support\Collection;
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
     * @throws \VK\VKException
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
    public function getPosts(?int $startTime, int $count = 100): PostsCollection
    {
        $response = $this->client->api('newsfeed.get', [
            'filters'    => 'post',
            'count'      => $count,
            'start_time' => $startTime
        ]);

        if (!array_key_exists('response', $response)) {
            throw new FeedRecordsNotFoundException();
        }

        $posts  = new PostsCollection($response['response']['items']);
        $groups = new Collection($response['response']['groups']);

        return $this->transformPosts($posts, $groups);
    }

    /**
     * TODO: Возможно нужно вынести в отдельный класс, в будущем нужно будет ещё обрабатывать вложения.
     *
     * @param PostsCollection $posts
     * @param Collection      $groups
     * @return PostsCollection
     */
    private function transformPosts(PostsCollection $posts, Collection $groups): PostsCollection
    {
        return $posts->filter(function ($post) {
            return $this->isRecordIsPost($post) && $this->isSourceNotBlocked($post);
        })->map(function ($post) use ($groups) {
            $group = $groups->where('id', abs($post['source_id']))->first();
            return new Post($post, new Group($group));
        });
    }

    /**
     * @param array $post
     * @return bool
     */
    private function isRecordIsPost(array $post): bool
    {
        return $post['post_type'] === 'post' && empty($post['copy_history']) && $post['marked_as_ads'] == 0;
    }

    private function isSourceNotBlocked(array $post)
    {
        $list = [
            34215577
        ];

        return !\in_array(abs($post['source_id']), $list, true);
    }
}