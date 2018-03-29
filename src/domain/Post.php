<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Post
{
    private $content;
    private $author;

    public function __construct($content, $author)
    {
        $this->content = $content;
        $this->author = $author;
    }

    public function content()
    {
        return $this->content;
    }

    public function author()
    {
        return $this->author;
    }
}
