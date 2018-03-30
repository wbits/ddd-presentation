<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\Application;

use InSided\DDD\Application\PostService;
use InSided\DDD\domain\Author;
use InSided\DDD\domain\Content;
use InSided\DDD\domain\Message;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostSortOrder;
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

    public function testItReturnsPostListsThatAreSortedByOldestFirst()
    {
        $mostRecentWrittenAt = new \DateTimeImmutable('2015-01-10');
        $oldestWrittenAt = new \DateTimeImmutable('2013-01-10');
        $this->repository->save($this->createAPost('foo', 'john', $mostRecentWrittenAt));
        $this->repository->save($this->createAPost('zap', 'jill', $oldestWrittenAt));

        $postList = array_values($this->service->getPostList());

        self::assertEquals($oldestWrittenAt, $postList[0]->writtenAt());
        self::assertEquals($mostRecentWrittenAt, $postList[1]->writtenAt());
    }

    public function testItReturnsPostListsByAuthorThatAreSortedByOldestFirst()
    {
        $mostRecentWrittenAt = new \DateTimeImmutable('2015-01-10');
        $oldestWrittenAt = new \DateTimeImmutable('2013-01-10');
        $this->repository->save($this->createAPost('foo', 'jill', $mostRecentWrittenAt));
        $this->repository->save($this->createAPost('zap', 'jill', $oldestWrittenAt));

        $postList = array_values($this->service->getPostListByAuthor(new Author('jill')));

        self::assertEquals($oldestWrittenAt, $postList[0]->writtenAt());
        self::assertEquals($mostRecentWrittenAt, $postList[1]->writtenAt());
    }

    public function testItCanReturnAPostListSortedByMostRecentFirst()
    {
        $oldestWrittenAt = new \DateTimeImmutable('2013-01-10');
        $mostRecentWrittenAt = new \DateTimeImmutable('2015-01-10');
        $this->repository->save($this->createAPost('zap', 'jill', $oldestWrittenAt));
        $this->repository->save($this->createAPost('foo', 'jill', $mostRecentWrittenAt));

        $postList = array_values($this->service->getPostList(PostSortOrder::mostRecentFirst()));

        self::assertEquals($mostRecentWrittenAt, $postList[0]->writtenAt());
        self::assertEquals($oldestWrittenAt, $postList[1]->writtenAt());
    }

    private function createAPost(string $content, string $authorName, \DateTimeImmutable $writtenAt = null): Post
    {
        return new Post(
            $this->repository->getNextId(),
            $this->createMessage($content, $authorName, $writtenAt)
        );
    }

    private function createMessage(string $content, string $authorName, \DateTimeImmutable $writtenAt = null): Message
    {
        $writtenAt = $writtenAt ?? new \DateTimeImmutable('now');

        return new Message(new Content($content), new Author($authorName), $writtenAt);
    }
}
