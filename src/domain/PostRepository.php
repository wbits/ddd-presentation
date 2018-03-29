<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

interface PostRepository
{
    public function getNextId(): PostId;

    public function get(PostId $postId): Post;

    /**
     * @return Post[]
     */
    public function getAll(): array;

    public function save(Post $post);
}
