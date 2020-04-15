<?php

namespace App\Blog\Controller;

use App\Blog\Repository\BlogRepository;
use App\Blog\Repository\Domain\Blog;
use App\Blog\Repository\Domain\BlogStatus;
use App\Core\Controller\CoreController;
use App\Core\Repository\OutOfBoundsException;
use App\Core\Service\View\View;

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
            $blog = $repository->findById($blogId);
            return View::render('blog/index.html.twig', compact('blog'));
        } catch (OutOfBoundsException $e) {
            return $e->getMessage();
        }
    }

    public function item(int $id)
    {
        return $id;
    }
}
