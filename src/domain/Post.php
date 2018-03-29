<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Post
{
    private $postId;
    private $content;
    private $author;

    public function __construct(PostId $postId, Content $content, Author $author)
    {
        $this->postId = $postId;
        $this->content = $content;
        $this->author = $author;
    }

    public static function write(PostId $postId, Content $content, Author $author)
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

    public function author(): Author
    {
        return $this->author;
    }

    public function changeContent(Content $newContent, Author $changedBy)
    {
        if ($changedBy != $this->author) {
            throw new \InvalidArgumentException('you are not allowed to change the content of this post');
        }

        $this->content = $newContent;
    }
}
