<?php

declare(strict_types = 1);

namespace InSided\DDD\domain;

final class PostSortOrder
{
    private $sortBy;
    private $ascending;

    private function __construct(string $sortBy, bool $ascending)
    {
        $this->sortBy = $sortBy;
        $this->ascending = $ascending;
    }

    public static function oldestFirst(): PostSortOrder
    {
        return new self('writtenAt', true);
    }

    public function sortBy(): string
    {
        return $this->sortBy;
    }

    public function isAscending(): bool
    {
        return $this->ascending;
    }
}
