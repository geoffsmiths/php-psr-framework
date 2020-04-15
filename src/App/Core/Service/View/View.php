<?php

namespace App\Core\Service\View;

use App\Core\Service\PhpDi\Di;
use Twig\Environment;

class View
{
    public static function render($name, array $context = []): string
    {
        try {
            $twig = Di::getContainer()->get(Environment::class);
            return $twig->render($name, $context);
        } catch (\Throwable $e) {
            dd($e);
        }

        return '';
    }
}
