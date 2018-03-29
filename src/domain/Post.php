<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Post
{
    private $content;
    private $author;

    public function __construct(Content $content, string $author)
    {
        $this->content = $content;
        $this->author = $author;
    }

    public static function write(Content $content, string $author)
    {
        return new self($content, $author);
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
