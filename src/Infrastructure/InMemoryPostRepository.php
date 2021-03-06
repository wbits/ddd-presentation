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
        return PostSorter::sort($postSortOrder, ...$this->posts);
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

        return PostSorter::sort($postSortOrder, ...$posts);
    }

    public function save(Post $post)
    {
        $this->posts[(string) $post->id()] = $post;
    }
}
