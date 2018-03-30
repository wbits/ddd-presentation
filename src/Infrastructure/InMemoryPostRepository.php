<?php

declare(strict_types = 1);

namespace InSided\DDD\Infrastructure;

use InSided\DDD\domain\Author;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use InSided\DDD\domain\PostRepository;
use InSided\DDD\domain\PostSortOrder;

final class InMemoryPostRepository implements PostRepository
{
    private $id = 0;
    private $posts = [];

    public function getNextId(): PostId
    {
        ++$this->id;

        return new PostId((string) $this->id);
    }

    public function get(PostId $postId): Post
    {
        return $this->posts[(string) $postId];
    }

    /**
     * @param PostSortOrder $postSortOrder
     *
     * @return Post[]
     */
    public function getAll(PostSortOrder $postSortOrder): array
    {
        if ($postSortOrder->isAscending()) {
            usort($this->posts, [$this, 'sortByOldestFirst']);
        } else {
            usort($this->posts, [$this, 'sortByMostRecentFirst']);
        }

        return $this->posts;
    }

    /**
     * @param Author $author
     * @param PostSortOrder $postSortOrder
     *
     * @return Post[]
     */
    public function getAllByAuthor(Author $author, PostSortOrder $postSortOrder): array
    {
        $posts = array_filter($this->posts, function (Post $post) use ($author) {
            return $post->author() == $author;
        });

        if ($postSortOrder->isAscending()) {
            usort($posts, [$this, 'sortByOldestFirst']);
        } else {
            usort($posts, [$this, 'sortByMostRecentFirst']);
        }

        return $posts;
    }

    public function save(Post $post)
    {
        $this->posts[(string) $post->id()] = $post;
    }

    private function sortByMostRecentFirst(Post $postA, Post $postB): int
    {
        if ($postA->writtenAt() == $postB->writtenAt()) {
            return 0;
        }

        return ($postA->writtenAt() > $postB->writtenAt()) ? -1 : 1;
    }

    private function sortByOldestFirst(Post $postA, Post $postB): int
    {
        if ($postA->writtenAt() == $postB->writtenAt()) {
            return 0;
        }

        return ($postA->writtenAt() < $postB->writtenAt()) ? -1 : 1;
    }
}
