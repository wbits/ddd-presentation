<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Post
{
    private $postId;
    private $content;
    private $author;

    public function __construct(PostId $postId, Content $content, string $author)
    {
        $this->postId = $postId;
        $this->content = $content;
        $this->author = $author;
    }

    public static function write(PostId $postId, Content $content, string $author)
    {
        return new self($postId, $content, $author);
    }

    public function id(): PostId
    {
        return $this->postId;
    }

    public function content(): Content
    {
        return $this->content;
    }

    public function author(): string
    {
        return $this->author;
    }
}
