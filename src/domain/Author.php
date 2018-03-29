<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class Author
{
    private $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('An author should have a name');
        }

        $this->name = $name;
    }
}

