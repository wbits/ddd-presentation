<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\Application;

use InSided\DDD\Application\PostService;
use InSided\DDD\domain\Author;
use InSided\DDD\domain\Content;
use InSided\DDD\domain\Message;
use InSided\DDD\domain\Post;
use InSided\DDD\domain\PostId;
use InSided\DDD\domain\PostRepository;
use PHPUnit\Framework\TestCase;

final class PostServiceTest extends TestCase
{
    public function testItCanSaveAndRetrieveAPost()
    {
        $message = new Message(new Content('some content'), new Author('Jack'), new \DateTimeImmutable());
        $postId = new PostId('1');
        $post = new Post($postId, $message);

        $repository = $this->prophesize(PostRepository::class);
        $repository->save($post)->willReturn($postId);
        $repository->get($postId)->willReturn($post);
        $repository->getNextId()->willReturn($postId);

        $service = new PostService($repository->reveal());

        self::assertEquals($postId, $service->writeAPost($message));
        self::assertEquals($post, $service->getPost($postId));
    }
}
