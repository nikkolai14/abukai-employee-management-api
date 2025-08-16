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
        parent::__construct($container['request'], $container['response']);
        $this->employeeModel = $container['employeeModel'];
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