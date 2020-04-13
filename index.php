<?php

require_once "vendor/autoload.php";

try {
    $di = new \App\Core\Service\PhpDi\PhpDi();
    $container = $di->getContainer();
} catch (Throwable $e) {
}

# let the router do the magic
try {
    $router = $container->make(\App\Core\Service\Router\Router::class);
    $router->load();
} catch(Throwable $e) {
    echo $e->getMessage();
}

