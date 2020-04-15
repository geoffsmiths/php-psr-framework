<?php

namespace App\Home\Controller;

use App\Core\Controller\CoreController;

class HomeController extends CoreController
{
    public function index()
    {
        $this->render('home/home.html.twig');
    }
}
