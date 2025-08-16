<?php

namespace App\Core;

class Router {
    private $routes = [];
    private $request;
    private $response;

    /**
     * Router constructor.
     *
     * @param object $request The request object.
     * @param object $response The response object.
     */
    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri The URI pattern.
     * @param string $controllerAction The controller and action in 'Controller@action' format.
     * @return void
     */
    public function get($uri, $controllerAction) {
        $this->routes['GET'][$uri] = $controllerAction;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri The URI pattern.
     * @param string $controllerAction The controller and action in 'Controller@action' format.
     * @return void
     */
    public function post($uri, $controllerAction) {
        $this->routes['POST'][$uri] = $controllerAction;
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

            // Assume controllers are in App\Controllers namespace
            $controllerClass = "App\\Controllers\\$controllerName";
            if (!class_exists($controllerClass)) {
                throw new Exception("Controller $controllerClass not found", 500);
            }

            $controller = new $controllerClass($this->request, $this->response);
            if (!method_exists($controller, $action)) {
                throw new Exception("Action $action not found in controller $controllerClass", 500);
            }

            return $controller->$action();
        }

        throw new Exception("Route not found", 404);
    }
}