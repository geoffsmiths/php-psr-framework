<?php

namespace App\Core;

use App\Core\Service\PhpDi\Di;
use App\Core\Service\Router\Router;
use Throwable;

class Kernel
{
    public static function init()
    {
        $container = Di::getContainer();

        try {
            # let the router do the magic
            ($container->make(Router::class))->load();

        } catch(Throwable $e) {
            echo $e->getMessage();
        }
    }
}
