<?php

namespace App\Core\Service\PhpDi;

use DI\Container;
use DI\ContainerBuilder;

class PhpDi
{
    const CONFIG_FILES = [
        __DIR__ . '/../../Resource/php-di/config.php',
    ];

    const CACHE_DIR = __DIR__ . '/../../../../../../var/cache';

    /**
     * @var Container
     */
    private $container;

    /**
     * Constructor PhpDi.
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        foreach (self::CONFIG_FILES as $configFile) {
            $builder->addDefinitions($configFile);
        }

        $builder->useAnnotations(true);

        if (!defined('TEST_ENVIRONMENT')) {
            $builder->enableCompilation(self::CACHE_DIR);
        }

        $this->container = $builder->build();
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
