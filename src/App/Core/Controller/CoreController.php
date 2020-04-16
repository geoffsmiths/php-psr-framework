<?php

namespace App\Core\Controller;

use DI\FactoryInterface;
use Mlaphp\Request;

class CoreController
{
    /**
     * @Inject
     * @var Request
     */
    protected $request;

    /**
     * @Inject
     * @var FactoryInterface
     */
    protected $factory;
}
