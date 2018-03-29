<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\domain;

use InSided\DDD\domain\Author;
use InSided\DDD\domain\Content;
use InSided\DDD\domain\Message;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use PHPUnit\Framework\TestCase;

final class PostTest extends TestCase
{
    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var \DateTimeImmutable
     */
    private $fakeNow;

    protected function setUp()
    {
        $this->postId = new PostId('1');
        $this->author = new Author('John Doe');
        $this->content = new Content('This is the content of a post');
        $this->fakeNow = new \DateTimeImmutable('now');
    }

    public function testItCanBeWrittenByAnAuthor()
    {
        $post = $this->writeAPost();

        self::assertEquals($this->content, $post->content());
        self::assertEquals($this->author, $post->author());
    }

    public function testItGetsWrittenWithAPostId()
    {
        $post = $this->writeAPost();

        self::assertEquals($this->postId, $post->id());
    }

    public function testTheContentCanBeChanged()
    {
        $post = $this->writeAPost();
        $newContent = new Content('some new content');

        $post->changeContent($newContent, $this->author);

        self::assertEquals($newContent, $post->content());
    }

    public function testItTheContentCanBeChangedOnlyByTheAuthorThatHasWrittenThePost()
    {
        $post = $this->writeAPost();
        $newContent = new Content('some new content');
        $authorThatChangesTheContent = new Author('Jennifer');

        $this->expectException(\InvalidArgumentException::class);

        $post->changeContent($newContent, $authorThatChangesTheContent);
    }

    public function testItRecordsTheTimeOnWhichItWasWritten()
    {
        $post = $this->writeAPost();

        self::assertEquals($this->fakeNow, $post->writtenAt());
    }

    private function writeAPost(): Post
    {
        return Post::write($this->postId, new Message($this->content, $this->author, $this->fakeNow));
    }
}
