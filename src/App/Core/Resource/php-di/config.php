<?php

use Mlaphp\Request;

return [
    Request::class => function (\DI\Container $container) {
        return new Request($GLOBALS);
    },
    \App\Core\Repository\PersistenceInterface::class => function (\DI\Container $container) {
        return $container->make(\App\Core\Repository\InMemoryPersistence::class);
    }
];
