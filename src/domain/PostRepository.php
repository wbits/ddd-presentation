<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

interface PostRepository
{
    public function getNextId(): PostId;

    public function get(PostId $postId): Post;

    /**
     * @param PostSortOrder $postSortOrder
     *
     * @return Post[]
     */
    public function getAll(PostSortOrder $postSortOrder): array;

    /**
     * @param Author $author
     * @param PostSortOrder $postSortOrder
     *
     * @return Post[]
     */
    public function getAllByAuthor(Author $author, PostSortOrder $postSortOrder): array;

    public function save(Post $post);
}
