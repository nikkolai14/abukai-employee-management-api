<?php

$employees = require_once __DIR__ . '/employee.php';

$routes = array_merge(
    $employees
);

return $routes;
