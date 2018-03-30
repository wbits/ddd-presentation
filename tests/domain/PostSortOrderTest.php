<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\PostSortOrder;
use PHPUnit\Framework\TestCase;

final class PostSortOrderTest extends TestCase
{
    public function testItDefinesSortingByWrittenAt()
    {
        $sortOrder = new PostSortOrder();

        self::assertEquals('writtenAt', $sortOrder->sortBy());
    }

    public function testItDefinesOrderByAscending()
    {
        $sortOrder = new PostSortOrder();

        self::assertTrue($sortOrder->isAscending());
    }
}
