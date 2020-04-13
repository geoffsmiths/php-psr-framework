<?php

namespace App\Core\Controller;

use DI\FactoryInterface;
use Mlaphp\Request;
use Twig\Environment;

class CoreController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var Environment
     */
    protected $twig;

    public function __construct(
        Request $request,
        FactoryInterface $factory,
        Environment $twig
    ) {
        $this->request = $request;
        $this->factory = $factory;
        $this->twig = $twig;
    }

    public function render($name, array $context = [])
    {
        try {
            echo $this->twig->render($name, $context);
        } catch (\Throwable $e) {
            // redirect to a 404 page
            dd($e);
        }
    }
}
