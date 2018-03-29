<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\Author;
use PHPUnit\Framework\TestCase;

final class AuthorTest extends TestCase
{
    public function testItCanNotBeCreatedWithoutAName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Author('');
    }
}
