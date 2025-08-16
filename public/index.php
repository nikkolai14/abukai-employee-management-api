<?php
require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;
use App\Core\Request;
use App\Core\Response;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Initialize the request and response objects
$request = new Request();
$response = new Response();

// Initialize the router
$router = new Router($request, $response);

// Define routes
$router->get('/api/employees', 'EmployeeController@getEmployees');
$router->post('/api/employees', 'EmployeeController@createEmployee');
$router->get('/api/employees/{id}', 'EmployeeController@getEmployeeById');
$router->put('/api/employees/{id}', 'EmployeeController@updateEmployee');
$router->delete('/api/employees/{id}', 'EmployeeController@deleteEmployee');

// Handle the request
$router->resolve();