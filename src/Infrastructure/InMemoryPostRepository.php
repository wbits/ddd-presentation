<?php

declare(strict_types = 1);

namespace InSided\DDD\Infrastructure;

use InSided\DDD\domain\Author;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use InSided\DDD\domain\PostRepository;

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
     * @return Post[]
     */
    public function getAll(): array
    {
        $sortingCallBack = function (Post $postA, Post $postB) {
            if ($postA->writtenAt() == $postB->writtenAt()) {
                return 0;
            }

            return ($postA->writtenAt() < $postB->writtenAt()) ? -1: 1;
        };

        usort($this->posts, $sortingCallBack);

        return $this->posts;
    }

    /**
     * @param Author $author
     *
     * @return Post[]
     */
    public function getAllByAuthor(Author $author): array
    {
        $posts = array_filter($this->posts, function (Post $post) use ($author) {
            return $post->author() == $author;
        });

        $sortingCallBack = function (Post $postA, Post $postB) {
            if ($postA->writtenAt() == $postB->writtenAt()) {
                return 0;
            }

            return ($postA->writtenAt() < $postB->writtenAt()) ? -1: 1;
        };

        usort($posts, $sortingCallBack);

        return $posts;
    }

    public function save(Post $post)
    {
        $this->posts[(string) $post->id()] = $post;
    }
}
