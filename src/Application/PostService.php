<?php

declare(strict_types = 1);

namespace InSided\DDD\Application;

use InSided\DDD\domain\Message;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use InSided\DDD\domain\PostRepository;

final class PostService
{
    private $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function writeAPost(Message $message): PostId
    {
        $postId = $this->repository->getNextId();
        $post = new Post($postId, $message);

        $this->repository->save($post);

        return $postId;
    }

    public function getPost(PostId $postId): Post
    {
        return $this->repository->get($postId);
    }

    /**
     * @return Post[]
     */
    public function getPostList(): array
    {
        return $this->repository->getAll();
    }

    public function getPostListByAuthor($author)
    {
        return [];
    }
}
