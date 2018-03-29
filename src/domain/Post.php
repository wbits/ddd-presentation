<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Post
{
    private $postId;
    private $content;
    private $author;
    private $writtenAt;

    public function __construct(PostId $postId, Content $content, Author $author, \DateTimeImmutable $writtenAt)
    {
        $this->postId = $postId;
        $this->content = $content;
        $this->author = $author;
        $this->writtenAt = $writtenAt;
    }

    public static function write(PostId $postId, Content $content, Author $author, \DateTimeImmutable $writtenAt)
    {
        return new self($postId, $content, $author, $writtenAt);
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

    public function writtenAt(): \DateTimeImmutable
    {
        return $this->writtenAt;
    }

    public function changeContent(Content $newContent, Author $changedBy)
    {
        if ($changedBy != $this->author) {
            throw new \InvalidArgumentException('you are not allowed to change the content of this post');
        }

        $this->content = $newContent;
    }
}
