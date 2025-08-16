<?php

$basePath = '/api/employees';

return [
    "$basePath" => ['GET', 'EmployeeController@getEmployees'],
    "$basePath" => ['POST', 'EmployeeController@createEmployee'],
    "$basePath/{id}" => ['GET', 'EmployeeController@getEmployeeById'],
    "$basePath/{id}" => ['PUT', 'EmployeeController@updateEmployee'],
    "$basePath/{id}" => ['DELETE', 'EmployeeController@deleteEmployee'],
];