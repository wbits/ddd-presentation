<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\Content;
use InSided\DDD\domain\Post;
use PHPUnit\Framework\TestCase;

final class PostTest extends TestCase
{
    public function testItCanBeWrittenByAnAuthor()
    {
        $content = new Content('This is the content of a post');
        $author = 'John Doe';
        $post = Post::write($content, $author);

        self::assertEquals($content, $post->content());
        self::assertEquals($author, $post->author());
    }

    public function testItRaisesAnErrorWhenTheContentIsShorterThenThreeCharacters()
    {
        $this->expectException(\InvalidArgumentException::class);

        Post::write(new Content('12'), 'John Doe');
    }

    public function testItRaisesAnErrorWhenTheContentIsLongerThenEightyCharacters()
    {
        $contentThatIsTooLong = '';
        for ($i = 1; $i <= 9; ++$i) {
            $contentThatIsTooLong .= '0123456789';
        }
        self::assertTrue(mb_strlen($contentThatIsTooLong) > 80);

        $this->expectException(\InvalidArgumentException::class);

        Post::write(new Content($contentThatIsTooLong), 'John Doe');
    }
}
