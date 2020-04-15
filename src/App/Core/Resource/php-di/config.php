<?php

use Mlaphp\Request;

return [
    Request::class => function (\DI\Container $container) {
        return new Request($GLOBALS);
    },
    \App\Core\Repository\PersistenceInterface::class => function (\DI\Container $container) {
        return $container->make(\App\Core\Repository\InMemoryPersistence::class);
    },
    \Twig\Environment::class => function (\DI\Container $container) {
        $paths = include_once __DIR__ . '/../twig/paths.php';
        $loader = new \Twig\Loader\FilesystemLoader($paths);
        $environment = new \Twig\Environment($loader, [
            'cache' => __DIR__ . '/../../../../../../var/twigcache',
            'auto_reload' => true, // disable in production!
            'debug' => true,
        ]);

        return $environment;
    }
];
