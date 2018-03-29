<?php

declare(strict_types = 1);

namespace unit\InSided\DDD\Application;

use InSided\DDD\Application\PostService;
use InSided\DDD\domain\Author;
use InSided\DDD\domain\Content;
use InSided\DDD\domain\Message;
use InSided\DDD\Infrastructure\InMemoryPostRepository;
use PHPUnit\Framework\TestCase;

final class PostServiceTest extends TestCase
{
    public function testItCanSaveAndRetrieveAPost()
    {
        $message = new Message(new Content('some content'), new Author('Jack'), new \DateTimeImmutable());
        $repository = new InMemoryPostRepository();
        $service = new PostService($repository);

        $postId = $service->writeAPost($message);
        $post = $service->getPost($postId);

        self::assertEquals($postId, $post->id());
    }
}
