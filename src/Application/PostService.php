<?php

declare(strict_types = 1);

namespace InSided\DDD\Application;

use InSided\DDD\domain\Author;
use InSided\DDD\domain\Message;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use InSided\DDD\domain\PostRepository;
use InSided\DDD\domain\PostSortOrder;

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
     * @param PostSortOrder $postSortOrder
     *
     * @return Post[]
     */
    public function getPostList(PostSortOrder $postSortOrder = null): array
    {
        return $this->repository->getAll($postSortOrder ?? PostSortOrder::oldestFirst());
    }

    /**
     * @param Author $author
     * @param PostSortOrder|null $postSortOrder
     *
     * @return Post[]
     */
    public function getPostListByAuthor(Author $author, PostSortOrder $postSortOrder = null): array
    {
        return $this->repository->getAllByAuthor($author, $postSortOrder ?? PostSortOrder::oldestFirst());
    }
}
