<?php

$employees = require_once __DIR__ . '/employees.php';

$routes = array_merge(
    $employees
);

return $routes;
