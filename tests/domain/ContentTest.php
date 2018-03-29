<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\Content;
use PHPUnit\Framework\TestCase;

final class ContentTest extends TestCase
{
    public function testItRaisesAnErrorWhenTheContentIsShorterThenThreeCharacters()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Content('12');
    }

    public function testItRaisesAnErrorWhenTheContentIsLongerThenEightyCharacters()
    {
        $contentThatIsTooLong = '';
        for ($i = 1; $i <= 9; ++$i) {
            $contentThatIsTooLong .= '0123456789';
        }
        self::assertTrue(mb_strlen($contentThatIsTooLong) > 80);

        $this->expectException(\InvalidArgumentException::class);

        new Content($contentThatIsTooLong);
    }
}
