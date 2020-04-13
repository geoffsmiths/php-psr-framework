<?php

namespace App\Blog\Controller;

use App\Blog\Repository\BlogRepository;
use App\Blog\Repository\Domain\Blog;
use App\Blog\Repository\Domain\BlogStatus;
use App\Core\Controller\CoreController;
use App\Core\Repository\OutOfBoundsException;

class BlogController extends CoreController
{
    public function index()
    {
        /** @var BlogRepository $repository */
        $repository = $this->factory->make(BlogRepository::class);
        $blogId = $repository->generateId();

        $repository->save(Blog::fromState([
            'id' => $blogId->toInt(),
            'name' => 'Our first blog',
            'description' => 'This is our blog description',
            'status' => BlogStatus::STATE_DRAFT
        ]));

        try {
            $found = $repository->findById($blogId);
            dd($found);
        } catch (OutOfBoundsException $e) {
            echo $e->getMessage();
        }
    }

    public function item(int $id)
    {
        echo $id;
    }
}
