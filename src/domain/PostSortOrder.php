<?php

declare(strict_types=1);

namespace InSided\DDD\domain;

final class PostSortOrder
{
    public function sortBy(): string
    {
        return 'writtenAt';
    }
}

