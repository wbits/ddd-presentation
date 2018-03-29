<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\Content;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use PHPUnit\Framework\TestCase;

final class PostTest extends TestCase
{
    public function testItCanBeWrittenByAnAuthor()
    {
        $postId = new PostId('1');
        $content = new Content('This is the content of a post');
        $author = 'John Doe';
        $post = Post::write($postId, $content, $author);

        self::assertEquals($content, $post->content());
        self::assertEquals($author, $post->author());
    }

    public function testItGetsWrittenWithAPostId()
    {
        $postId = new PostId('1');
        $content = new Content('This is the content of a post');
        $author = 'John Doe';
        $post = Post::write($postId, $content, $author);

        self::assertEquals($postId, $post->id());
    }
}
