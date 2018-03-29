<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class PostId
{
    private $postId;

    public function __construct(string $postId)
    {
        if (empty($postId)) {
            throw new \InvalidArgumentException('a postId can not be empty');
        }

        $this->postId = $postId;
    }
}

