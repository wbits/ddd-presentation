<?php

declare(strict_types=1);

namespace InSided\DDD\Application;

use InSided\DDD\domain\PostRepository;

final class PostService
{
    private $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function writeAPost($message)
    {
    }

    public function getPost($postId)
    {
    }
}

