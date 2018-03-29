<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\Post;
use PHPUnit\Framework\TestCase;

final class PostTest extends TestCase
{
    public function testItCanBeWrittenByAnAuthor()
    {
        $content = 'This is the content of a post';
        $author = 'John Doe';
        $post = Post::write($content, $author);

        self::assertEquals($content, $post->content());
        self::assertEquals($author, $post->author());
    }

    public function testItRaisesAnErrorWhenTheContentIsShorterThenThreeCharacters()
    {
        $this->expectException(\InvalidArgumentException::class);

        Post::write('12', 'John Doe');
    }
}
