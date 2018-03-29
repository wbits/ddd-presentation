<?php

declare(strict_types = 1);

namespace InSided\DDD\Infrastructure;

use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use InSided\DDD\domain\PostRepository;

final class InMemoryPostRepository implements PostRepository
{
    private $id = 0;
    private $posts = [];

    public function getNextId(): PostId
    {
        $id = $this->id++;

        return new PostId((string) $id);
    }

    public function get(PostId $postId): Post
    {
        return $this->posts[(string) $postId];
    }

    public function save(Post $post)
    {
        $this->posts[(string) $post->id()] = $post;
    }
}
