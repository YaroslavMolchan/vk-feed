<?php

namespace App\Rules;

use App\Contracts\PostCheckerInterface;
use App\Dto\Group;
use App\Dto\Post;

/**
 * Class VkPostChecker
 */
class VkPostChecker implements PostCheckerInterface
{
    /**
     * @param Post $post
     * @return bool
     */
    public function passes(Post $post): bool
    {
        return ! ($this->isAdsRecord($post) || $this->isGroupBlocked($post->group));
    }

    /**
     * @param Post $post
     * @return bool
     */
    private function isAdsRecord(Post $post): bool
    {
        return $post->isAds === true;
    }

    /**
     * @param Group $group
     * @return bool
     */
    private function isGroupBlocked(Group $group): bool
    {
        $list = [
            34215577
        ];
        return \in_array($group->id, $list, true);
    }
}