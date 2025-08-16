<?php

require_once '../vendor/autoload.php';
$dbConfig = require __DIR__ . '/../config/database.php';

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

// Define routes
$router->get('/api/employees', 'EmployeeController@getEmployees');
$router->post('/api/employees', 'EmployeeController@createEmployee');
$router->get('/api/employees/{id}', 'EmployeeController@getEmployeeById');
$router->put('/api/employees/{id}', 'EmployeeController@updateEmployee');
$router->delete('/api/employees/{id}', 'EmployeeController@deleteEmployee');

// Handle the request
$router->resolve();