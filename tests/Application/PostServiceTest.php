<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\Application;

use InSided\DDD\Application\PostService;
use InSided\DDD\domain\Author;
use InSided\DDD\domain\Content;
use InSided\DDD\domain\Message;
use InSided\DDD\domain\Post;
use InSided\DDD\Infrastructure\InMemoryPostRepository;
use PHPUnit\Framework\TestCase;

final class PostServiceTest extends TestCase
{
    /**
     * @var InMemoryPostRepository
     */
    private $repository;
    /**
     * @var PostService
     */
    private $service;

    protected function setUp()
    {
        $this->repository = new InMemoryPostRepository();
        $this->service = new PostService($this->repository);
    }

    public function testItCanSaveAndRetrieveAPost()
    {
        $postId = $this->service->writeAPost($this->createMessage('some content', 'Jack'));
        $post = $this->service->getPost($postId);

        self::assertEquals($postId, $post->id());
    }

    public function testItReturnsAnEmptyArrayWhenNoPostsWereWritten()
    {
        self::assertCount(0, $this->service->getPostList());
    }

    public function testItCanFetchAListOfReplies()
    {
        $this->repository->save($this->createAPost('foo', 'john'));
        $this->repository->save($this->createAPost('bar', 'jack'));
        $this->repository->save($this->createAPost('zap', 'jill'));

        $postList = $this->service->getPostList();

        self::assertCount(3, $postList);

        foreach ($postList as $post) {
            self::assertInstanceOf(Post::class, $post);
        }
    }

    public function testItCanFetchAListOfRepliesOfAGivenAuthor()
    {
        $this->repository->save($this->createAPost('foo', 'john'));
        $this->repository->save($this->createAPost('bar', 'john'));
        $this->repository->save($this->createAPost('zap', 'jill'));

        $author = new Author('john');
        $postList = $this->service->getPostListByAuthor($author);

        self::assertCount(2, $postList);

        foreach ($postList as $post) {
            self::assertEquals($author, $post->author());
        }
    }

    private function createAPost(string $content, string $authorName): Post
    {
        return new Post(
            $this->repository->getNextId(),
            $this->createMessage($content, $authorName)
        );
    }

    private function createMessage(string $content, string $authorName): Message
    {
        return new Message(new Content($content), new Author($authorName), new \DateTimeImmutable());
    }
}
