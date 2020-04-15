<?php

namespace App\Blog\Command;

use App\Blog\Repository\BlogRepository;
use App\Blog\Repository\Domain\Blog;
use App\Blog\Repository\Domain\BlogStatus;

class BlogDraft
{
    /**
     * @var BlogRepository
     */
    private $repository;

    public function __construct(BlogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $name
     * @param string $description
     *
     * @return Blog
     * @throws \App\Core\Repository\OutOfBoundsException
     */
    public function save(string $name, string $description): Blog
    {
        $blogId = $this->repository->generateId();

        $this->repository->save(Blog::fromState([
            'id' => $blogId->toInt(),
            'name' => $name,
            'description' => $description,
            'status' => BlogStatus::STATE_DRAFT
        ]));

        return $this->repository->findById($blogId);
    }
}
