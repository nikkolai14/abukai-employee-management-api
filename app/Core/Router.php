<?php

namespace App\Core;

class Router {
    private $routes = [];
    private $container = [];
    private $request;

    /**
     * Router constructor.
     *
     * @param array $container Container for shared dependencies.
     */
    public function __construct($container = []) {
        $this->container = $container;

        if (isset($container['request']) && is_object($container['request'])) {
            $this->request = $container['request'];
        } else {
            throw new \Exception("Request object not found in container", 500);
        }
    }

    /**
     * Add a route to the router.
     *
     * @param string $uri The URI pattern.
     * @param string $controllerAction The controller action in 'Controller@action' format.
     * @param string $method The HTTP method (GET, POST, etc.).
     * @return void
     */
    public function addRoute($uri, $controllerAction, $method) {
        if (isset($this->routes[$method][$uri])) {
            throw new \Exception("Route $uri already exists", 500);
        }

        $this->routes[$method][$uri] = $controllerAction;
    }

    /**
     * Resolve the current request to a controller action.
     *
     * @throws \Exception If the route, controller, or action is not found.
     * @return mixed The result of the controller action.
     */
    public function resolve() {
        $uri = $this->request->getUri();
        $method = $this->request->getMethod();

        if (isset($this->routes[$method][$uri])) {
            $controllerAction = $this->routes[$method][$uri];

            // Split controller and action
            list($controllerName, $action) = explode('@', $controllerAction);

            // Assume controllers are in App\\Controllers namespace
            $controllerClass = "App\\Controllers\\$controllerName";
            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller $controllerClass not found", 500);
            }

            // Pass the whole container to the controller's constructor
            // WARNING: For large projects, this could lead to performance issues
            $controller = new $controllerClass($this->container);

            if (!method_exists($controller, $action)) {
                throw new \Exception("Action $action not found in controller $controllerClass", 500);
            }

            return $controller->$action();
        }

        throw new \Exception("Route not found", 404);
    }
}