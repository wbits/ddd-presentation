<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Post
{
    private $postId;
    private $message;

    public function __construct(PostId $postId, Message $message)
    {
        $this->postId = $postId;
        $this->message = $message;
    }

    public static function write(PostId $postId, Message $message)
    {
        return new self($postId, $message);
    }

    public function id(): PostId
    {
        return $this->postId;
    }

    public function content(): Content
    {
        return $this->message->content();
    }

    public function author(): Author
    {
        return $this->message->author();
    }

    public function writtenAt(): \DateTimeImmutable
    {
        return $this->message->writtenAt();
    }

    public function changeContent(Content $newContent, Author $changedBy)
    {
        $this->message = Message::cloneWithNewContent($this->message, $newContent, $changedBy);
    }
}
