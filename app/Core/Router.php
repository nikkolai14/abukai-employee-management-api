<?php

namespace App\Core;

class Router {
    private $routes = [];
    private $routePatterns = [];
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
     * @param string $uri The URI pattern (may contain {param}).
     * @param string $controllerAction The controller action in 'Controller@action' format.
     * @param string $method The HTTP method (GET, POST, etc.).
     * @return void
     */
    public function addRoute($uri, $controllerAction, $method) {
        // Convert URI pattern to regex and extract parameter names
        $pattern = preg_replace_callback('/\{(\w+)\}/', function ($matches) {
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $uri);

        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'pattern' => $pattern,
            'controllerAction' => $controllerAction
        ];
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

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                $controllerAction = $route['controllerAction'];

                list($controllerName, $action) = explode('@', $controllerAction);

                $controllerClass = "App\\Controllers\\$controllerName";
                if (!class_exists($controllerClass)) {
                    throw new \Exception("Controller $controllerClass not found", 500);
                }

                $controller = new $controllerClass($this->container);
                if (!method_exists($controller, $action)) {
                    throw new \Exception("Action $action not found in controller $controllerClass", 500);
                }

                // Extract only named parameters (ignore numeric keys)
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                return call_user_func_array([$controller, $action], $params);
            }
        }

        throw new \Exception("Route not found", 404);
    }
}