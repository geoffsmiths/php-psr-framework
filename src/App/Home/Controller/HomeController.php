<?php

namespace App\Home\Controller;

use App\Core\Controller\CoreController;
use App\Core\Service\View\View;

class HomeController extends CoreController
{
    public function index()
    {
        return View::render('home/home.html.twig');
    }
}
