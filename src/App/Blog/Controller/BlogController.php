<?php

namespace App\Blog\Controller;

use App\Blog\Command\BlogDraft;
use App\Core\Controller\CoreController;
use App\Core\Repository\OutOfBoundsException;
use App\Core\Service\View\View;

class BlogController extends CoreController
{
    /**
     * @var BlogDraft
     */
    private $blogDraft;

    public function __construct(BlogDraft $blogDraft)
    {
        $this->blogDraft = $blogDraft;
    }

    public function index()
    {
        try {
            $blog = $this->blogDraft->save(
                'Our first blog',
                'This is our blog description'
            );

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
