<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;
use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dbConfig = require __DIR__ . '/../config/database.php';
$routes = require __DIR__ . '/../app/Routes/index.php';
$modelFactories = require __DIR__ . '/../app/Models/index.php';

// Initialize the request and response objects
$request = new Request();
$response = new Response();

// Database config
$database = new Database($dbConfig);

// Load models
$models = [];
foreach ($modelFactories as $key => $factory) {
    $models[$key] = $factory($database);
}

// Dependencides
$container = array_merge([
    'request' => $request,
    'response' => $response,
], $models);

$router = new Router($container);

// Load routes
foreach ($routes as $route) {
	if (count($route) === 3) {
		list($method, $uri, $controllerAction) = $route;
		$router->addRoute($uri, $controllerAction, $method);
		continue;
	}

    throw new \Exception("Route found that does not match expected format", 404);
}

// Handle the request
$router->resolve();