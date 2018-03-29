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
        $message = new Message(new Content('some content'), new Author('Jack'), new \DateTimeImmutable());

        $postId = $this->service->writeAPost($message);
        $post = $this->service->getPost($postId);

        self::assertEquals($postId, $post->id());
    }

    public function testItReturnsAnEmptyArrayWhenNoPostsWereWritten()
    {
        self::assertCount(0, $this->service->getPostList());
    }

    public function testItCanFetchAListOfReplies()
    {
        $postId1 = $this->repository->getNextId();
        $postId2 = $this->repository->getNextId();
        $postId3 = $this->repository->getNextId();
        $message = new Message(new Content('some content'), new Author('Jack'), new \DateTimeImmutable());
        $this->repository->save(new Post($postId1, $message));
        $this->repository->save(new Post($postId2, $message));
        $this->repository->save(new Post($postId3, $message));

        $postList = $this->service->getPostList();

        self::assertCount(3, $postList);

        foreach ($postList as $post) {
            self::assertInstanceOf(Post::class, $post);
        }
    }
}
