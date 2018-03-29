<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

interface PostRepository
{
    public function getNextId(): PostId;

    public function get(PostId $postId): Post;

    public function save(Post $post);
}
