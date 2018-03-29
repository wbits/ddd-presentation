<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Content
{
    private $content;

    public function __construct(string $content)
    {
        if (mb_strlen($content) < 3) {
            throw new \InvalidArgumentException('the content is too short');
        }

        if (mb_strlen($content) > 80) {
            throw new \InvalidArgumentException('the content is too long');
        }

        $this->content = $content;
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
