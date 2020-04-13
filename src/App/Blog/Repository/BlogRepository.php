<?php

namespace App\Blog\Repository;

use App\Blog\Repository\Domain\Blog;
use App\Blog\Repository\Domain\BlogId;
use App\Core\Repository\OutOfBoundsException;
use App\Core\Repository\PersistenceInterface;

class BlogRepository
{
    /**
     * @var PersistenceInterface
     */
    private $persistence;

    /**
     * Constructor BlogRepository.
     */
    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }

    public function generateId(): BlogId
    {
        return BlogId::fromInt($this->persistence->generateId());
    }

    /**
     * @param BlogId $blogId
     *
     * @return Blog
     * @throws OutOfBoundsException
     */
    public function findById(BlogId $blogId): Blog
    {
        try {
            $arrayData = $this->persistence->retrieve($blogId->toInt());
        } catch (OutOfBoundsException $e) {
            throw new OutOfBoundsException(sprintf('BlogID with ID %d not found', $blogId->toInt()), 0, $e);
        }

        return Blog::fromState($arrayData);
    }

    public function save(Blog $blog)
    {
        $this->persistence->persist([
            'id' => $blog->getId()->toInt(),
            'name' => $blog->getName()->toString(),
            'description' => $blog->getDescription()->toString(),
            'status' => $blog->getStatus()->toString()
        ]);
    }
}
