<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    /**
     * @var EmployeeModel
     */
    protected $employeeModel;

    public function __construct($container) {
        if (isset(
            $container['request'],
            $container['response'],
            $container['employeeModel']
        )) {
            parent::__construct($container['request'], $container['response']);
            $this->employeeModel = $container['employeeModel'];
        } else {
            throw new \Exception("EmployeeController dependencies not found", 500);
        }
    }

    public function createEmployee()
    {
        try {
            $data['name'] = $this->request->getPostData('name');
            $data['email'] = $this->request->getPostData('email');
            $data['position'] = $this->request->getPostData('position');
            $data['salary'] = $this->request->getPostData('salary');

            $record = $this->employeeModel->getEmployeeByEmail($data['email']);

            if ($record) {
                return $this->response::error('Employee already exists', 409);
            }

            $this->employeeModel->addEmployee($data);

            $response = ['status' => 'success'];

            $this->response::success($response, 201);
        } catch (\Exception $e) {
            $this->response::error($e->getMessage(), 500);
        }
    }

    public function getEmployees()
    {
        $search = $this->request->getQueryParam('search', null);
        $limit = $this->request->getQueryParam('limit', null);
        $page = $this->request->getQueryParam('page', 1);

        $filters = [];

        if (!empty($search)) {
            $filters['search'] = $search;
        }

        if (!empty($limit)) {
            $filters['limit'] = $limit;
        }

        if (!empty($page)) {
            $filters['page'] = $page;
        }

        $records = $this->employeeModel->getAllEmployees($filters);

        if (empty($records)) {
            return $this->response::error('No employees found', 404);
        }

        return $this->response::success($records);
    }

    public function getEmployeeById($id)
    {
        $record = $this->employeeModel->getEmployeeById($id);

        if (!$record) {
            return $this->response::error('Employee not found', 404);
        }

        return $this->response::success($record);
    }

    public function updateEmployee($id)
    {
        try {
            $record = $this->employeeModel->getEmployeeById($id);
            if (!$record) {
                return $this->response::error('Employee not found', 404);
            }

            $data['name'] = $this->request->getPostData('name');
            $data['email'] = $this->request->getPostData('email');
            $data['position'] = $this->request->getPostData('position');
            $data['salary'] = $this->request->getPostData('salary');

            $this->employeeModel->updateEmployee($id, $data);

            return $this->response::success(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response::error($e->getMessage(), 500);
        }
    }

    public function deleteEmployee($id)
    {
        try {
            $record = $this->employeeModel->getEmployeeById($id);
            if (!$record) {
                return $this->response::error('Employee not found', 404);
            }

            $this->employeeModel->deleteEmployee($id);

            return $this->response::success(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response::error($e->getMessage(), 500);
        }
    }
}