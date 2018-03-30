<?php

declare(strict_types = 1);

namespace InSided\DDD\Infrastructure;

use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostSortOrder;

final class PostSorter
{
    /**
     * @param PostSortOrder $sortOrder
     * @param Post[] $posts
     *
     * @return Post[]
     */
    public static function sort(PostSortOrder $sortOrder, Post ...$posts): array
    {
        if ($sortOrder->isAscending()) {
            usort($posts, [PostSorter::class, 'sortByOldestFirst']);
        } else {
            usort($posts, [PostSorter::class, 'sortByMostRecentFirst']);
        }

        return $posts;
    }

    private static function sortByMostRecentFirst(Post $postA, Post $postB): int
    {
        if ($postA->writtenAt() == $postB->writtenAt()) {
            return 0;
        }

        return ($postA->writtenAt() > $postB->writtenAt()) ? -1 : 1;
    }

    private static function sortByOldestFirst(Post $postA, Post $postB): int
    {
        if ($postA->writtenAt() == $postB->writtenAt()) {
            return 0;
        }

        return ($postA->writtenAt() < $postB->writtenAt()) ? -1 : 1;
    }
}
