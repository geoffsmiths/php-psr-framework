<?php

namespace App\Core\Service\Router;

use DI\FactoryInterface;
use Mlaphp\Request;

class Router
{
    const WEB_ROUTES = __DIR__ . '/../../../../../routes/web.php';
    /**
     * @var Request
     */
    private $request;

    /**
     * @var FactoryInterface
     */
    private $factory;

    public function __construct(Request $request, FactoryInterface $factory)
    {
        $this->request = $request;
        $this->factory = $factory;
    }

    /**
     * @throws ClassNotFoundException
     * @throws MethodNotFoundException
     * @throws RouteArgumentException
     * @throws RouteNotFoundException
     * @throws WebRoutesNotFoundException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function load()
    {
        $uri = $this->getUri();
        $webRoutes = $this->getWebRoutes();
        $foundRoute = $this->getAvailableRoute($uri, $webRoutes);
        $methodArguments = explode('/', $uri);
        array_shift($methodArguments);

        $methodVariables = explode('/', $foundRoute);
        array_shift($methodVariables);

        if (count($methodArguments) !== count($methodVariables)) {
            throw new RouteArgumentException("Route argument discrepancy");
        }

        $classBluePrint = explode('@', $webRoutes[$foundRoute]);
        $controllerClass = $classBluePrint[0];
        $method = $classBluePrint[1];

        // Prepare the namespace to look for
        $ns = str_replace('Controller', '', $controllerClass);
        $className = "App\\{$ns}\\Controller\\{$controllerClass}";
        if (!class_exists($className)) {
            throw new ClassNotFoundException("{$className} not found!");
        }

        $class = $this->factory->make($className);

        if (!method_exists($class, $method)) {
            throw new MethodNotFoundException("{$className}::{$method} does not exist!");
        }

        $class = $this->factory->make($className);
        $class->$method(...$methodArguments);
    }

    /**
     * @return mixed|string
     */
    protected function getUri()
    {
        $uri = $this->request->server['REQUEST_URI'];

        // strip leading /
        $uri = mb_substr($uri, 1);
        return $uri;
    }

    /**
     * @return mixed
     * @throws WebRoutesNotFoundException
     */
    protected function getWebRoutes()
    {
        $webRoutes = include_once self::WEB_ROUTES;

        if (!is_array($webRoutes)) {
            throw new WebRoutesNotFoundException("WebRoutes not found");
        }
        return $webRoutes;
    }

    /**
     * @param string $uri
     * @param $webRoutes
     *
     * @return int|string|null
     * @throws RouteNotFoundException
     */
    protected function getAvailableRoute(string $uri, $webRoutes)
    {
        $foundRoute = null;
        if (array_key_exists($uri, $webRoutes)) {
            $foundRoute = $uri;
        } else if (strpos($uri, '/') !== false) {
            $uriParts = explode('/', $uri);

            if (count($uriParts) > 1) {
                foreach ($webRoutes as $webUri => $webRoute) {
                    if (strpos($webUri, $uriParts[0]) === false) {
                        continue;
                    }

                    $webUriParts = explode('/', $webUri);
                    if (count($webUriParts) !== count($uriParts)) {
                        continue;
                    }

                    $foundRoute = $webUri;
                }
            }
        }

        if (!$foundRoute) {
            Throw new RouteNotFoundException("Route '{$uri}' does not exist!");
        }

        return $foundRoute;
    }
}
