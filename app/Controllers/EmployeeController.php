<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Core\Request;
use App\Core\Response;
class EmployeeController extends BaseController
{
    /**
     * @var EmployeeModel
     */
    protected $employeeModel;

    public function __construct($container) {
        if (isset($container['request']) && 
            is_object($container['request']) &&
            isset($container['response']) && 
            is_object($container['response']) &&
            isset($container['employeeModel']) && 
            is_object($container['employeeModel'])
        ) {
            parent::__construct($container['request'], $container['response']);
            $this->employeeModel = $container['employeeModel'];
        } else {
            throw new \Exception("EmployeeController dependencies not found", 500);
        }
    }

    public function createEmployee()
    {

    }

    public function getEmployes()
    {

    }

    public function getEmployeeById()
    {

    }

    public function updateEmployee($id)
    {

    }

    public function deleteEmployee($id)
    {

    }
}