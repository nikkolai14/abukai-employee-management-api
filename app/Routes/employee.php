<?php

$basePath = '/api/employees';

return [
    // [method, uri, controller@action]
    ['GET',    "$basePath",           'EmployeeController@getEmployees', []],
    ['POST',   "$basePath",           'EmployeeController@createEmployee', ['EmployeeValidation']],
    ['GET',    "$basePath/{id}",      'EmployeeController@getEmployeeById', []],
    ['PUT',    "$basePath/{id}",      'EmployeeController@updateEmployee', []],
    ['DELETE', "$basePath/{id}",      'EmployeeController@deleteEmployee', []],
];