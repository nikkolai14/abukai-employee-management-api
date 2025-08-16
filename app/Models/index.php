<?php

use App\Models\EmployeeModel;

return [
    'employeeModel' => function($database) {
        return new EmployeeModel($database);
    },
];