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
            $router = $container->make(Router::class);
            $router->load();

            
        } catch(Throwable $e) {
            echo $e->getMessage();
        }
    }
}
