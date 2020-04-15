<?php

namespace App\Core\Controller;

use DI\FactoryInterface;
use Mlaphp\Request;

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

    public function __construct(
        Request $request,
        FactoryInterface $factory
    ) {
        $this->request = $request;
        $this->factory = $factory;
    }
}
