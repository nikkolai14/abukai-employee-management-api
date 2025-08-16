<?php

require_once '../vendor/autoload.php';

$dbConfig = require __DIR__ . '/../config/database.php';
$routes = require __DIR__ . '/../app/Routes/index.php';

use Dotenv\Dotenv;
use App\Core\Router;
use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Models\EmployeeModel;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Initialize the request and response objects
$request = new Request();
$response = new Response();

// Database config
$database = new Database($dbConfig);
$employeeModel = new EmployeeModel($database);

// Dependencides
$container = [
	'request' => $request,
	'response' => $response,
	'employeeModel' => $employeeModel
];

$router = new Router($container);

// Load routes
foreach ($routes as $uri => $route) {
	$method = $route[0];
	$controllerAction = $route[1];
	$router->addRoute($uri, $controllerAction, $method);
}

// Handle the request
$router->resolve();