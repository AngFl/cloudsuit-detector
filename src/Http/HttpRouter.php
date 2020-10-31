<?php
/**
 *
 */

namespace App\Http;


use League\Route\Router;

class HttpRouter
{
    private Router $router;

    /**
     * HttpRouter constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function registerMiddleRoute(string $path, string $className, string $method)
    {
        return $this->router->map('GET', $path, [$className, $method]);
    }
}