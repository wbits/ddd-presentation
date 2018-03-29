<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\Content;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use PHPUnit\Framework\TestCase;

final class PostTest extends TestCase
{
    /**
     * @var string
     */
    private $author;

    /**
     * @var Content
     */
    private $content;

    protected function setUp()
    {
        $this->author = 'John Doe';
        $this->content = new Content('This is the content of a post');
    }

    public function testItCanBeWrittenByAnAuthor()
    {
        $postId = new PostId('1');
        $post = Post::write($postId, $this->content, $this->author);

        self::assertEquals($this->content, $post->content());
        self::assertEquals($this->author, $post->author());
    }

    public function testItGetsWrittenWithAPostId()
    {
        $postId = new PostId('1');
        $post = Post::write($postId, $this->content, $this->author);

        self::assertEquals($postId, $post->id());
    }
}
