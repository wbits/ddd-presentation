<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\PostId;
use PHPUnit\Framework\TestCase;

final class PostIdTest extends TestCase
{
    public function testItCanNotBeCreatedWithAnEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new PostId('');
    }
}

