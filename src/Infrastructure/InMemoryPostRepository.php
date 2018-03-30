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
        $this->id++;

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
        return $this->posts;
    }

    public function getAllByAuthor(Author $author): array
    {
        // TODO: Implement getAllByAuthor() method.
    }

    public function save(Post $post)
    {
        $this->posts[(string) $post->id()] = $post;
    }
}
