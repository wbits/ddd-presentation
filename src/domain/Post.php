<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Post
{
    private $content;
    private $author;

    public function __construct(string $content, string $author)
    {
        if (mb_strlen($content) < 3) {
            throw new \InvalidArgumentException('the content is too short');
        }

        if (mb_strlen($content) > 80) {
            throw new \InvalidArgumentException('the content is too long');
        }

        $this->content = $content;
        $this->author = $author;
    }

    public static function write(string $content, string $author)
    {
        return new self($content, $author);
    }

    public function content(): string
    {
        return $this->content;
    }

    public function author(): string
    {
        return $this->author;
    }
}
