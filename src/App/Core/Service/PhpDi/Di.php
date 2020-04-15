<?php

namespace App\Core\Service\PhpDi;

use Throwable;

class Di
{
    private static $instance;

    /**
     * @var \DI\Container
     */
    protected $container;

    private function __construct()
    {
        try {
            $this->container = (new PhpDi())->getContainer();
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }

    public static function getContainer()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance->container;
    }
}
