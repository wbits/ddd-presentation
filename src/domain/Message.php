<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Message
{
    private $content;
    private $author;
    private $writtenAt;

    public function __construct(Content $content, Author $author, \DateTimeImmutable $writtenAt)
    {
        $this->content = $content;
        $this->author = $author;
        $this->writtenAt = $writtenAt;
    }

    public static function cloneWithNewContent(Message $message, Content $newContent, Author $changedBy): Message
    {
        if ($changedBy != $message->author) {
            throw new \InvalidArgumentException('the content can only be changed by the original author');
        }

        return new self($newContent, $message->author, $message->writtenAt);
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
}
