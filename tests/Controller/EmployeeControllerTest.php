<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\EmployeeController;
use App\Models\EmployeeModel;
use App\Core\Request;
use App\Core\Response;

class EmployeeControllerTest extends TestCase
{
    private $controller;
    private $employeeModelMock;
    private $requestMock;
    private $responseMock;

    protected function setUp(): void
    {
        $this->employeeModelMock = $this->createMock(EmployeeModel::class);
        $this->requestMock = $this->createMock(Request::class);
        $this->responseMock = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->getMock();

        $container = [
            'request' => $this->requestMock,
            'response' => $this->responseMock,
            'employeeModel' => $this->employeeModelMock
        ];
        $this->controller = new EmployeeController($container);
    }

    public function testGetEmployeeByIdReturnsSuccess()
    {
        $employee = ['id' => 1, 'name' => 'John Doe'];

        $this->employeeModelMock->method('getEmployeeById')->willReturn($employee);

        $result = $this->controller->getEmployeeById(1);

        $this->assertEquals($this->responseMock->success($employee), $result);
    }

    public function testGetEmployeeByIdReturnsError()
    {
        $this->employeeModelMock->method('getEmployeeById')->willReturn(null);

        $result = $this->controller->getEmployeeById(999);

        $this->assertEquals($this->responseMock->error('Employee not found', 404), $result);
    }

    public function testCreateEmployeeSuccess()
    {
        $postData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'position' => 'Manager',
            'salary' => 5000
        ];

        $this->requestMock->method('getPostData')
            ->willReturnCallback(function ($key) use ($postData) {
                return $postData[$key];
            });
        $this->employeeModelMock->method('getEmployeeByEmail')->willReturn(null);
        $this->employeeModelMock->expects($this->once())->method('addEmployee')->with($postData);
        $this->responseMock->method('success')->willReturn('success');

        $result = $this->controller->createEmployee();
        $this->assertEquals('success', $result);
    }

    public function testCreateEmployeeAlreadyExists()
    {
        $postData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'position' => 'Manager',
            'salary' => 5000
        ];
        $this->requestMock->method('getPostData')
            ->willReturnCallback(function ($key) use ($postData) {
                return $postData[$key];
            });
        $this->employeeModelMock->method('getEmployeeByEmail')->willReturn(['id' => 2]);
        $this->responseMock->method('error')->willReturn('error');

        $result = $this->controller->createEmployee();
        $this->assertEquals('error', $result);
    }

    public function testGetEmployeesSuccess()
    {
        $filters = [
            'search' => 'John',
            'limit' => 10,
            'page' => 1
        ];
        $records = [
            ['id' => 1, 'name' => 'John Doe']
        ];
        $this->requestMock->method('getQueryParam')
            ->willReturnMap([
                ['search', null, 'John'],
                ['limit', null, 10],
                ['page', 1, 1]
            ]);
        $this->employeeModelMock->method('getAllEmployees')->with($filters)->willReturn($records);
        $this->responseMock->method('success')->willReturn('success');

        $result = $this->controller->getEmployees();
        $this->assertEquals('success', $result);
    }

    public function testGetEmployeesNotFound()
    {
        $this->requestMock->method('getQueryParam')->willReturn(null);
        $this->employeeModelMock->method('getAllEmployees')->willReturn([]);
        $this->responseMock->method('error')->willReturn('error');

        $result = $this->controller->getEmployees();
        $this->assertEquals('error', $result);
    }

    public function testUpdateEmployeeSuccess()
    {
        $id = 1;
        $record = ['id' => $id, 'name' => 'John Doe'];
        $postData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'position' => 'Manager',
            'salary' => 5000
        ];
        $this->employeeModelMock->method('getEmployeeById')->with($id)->willReturn($record);
        $this->requestMock->method('getPostData')
            ->willReturnCallback(function ($key) use ($postData) {
                return $postData[$key];
            });
        $this->employeeModelMock->expects($this->once())->method('updateEmployee')->with($id, $postData);
        $this->responseMock->method('success')->willReturn('success');

        $result = $this->controller->updateEmployee($id);
        $this->assertEquals('success', $result);
    }

    public function testUpdateEmployeeNotFound()
    {
        $id = 999;
        $this->employeeModelMock->method('getEmployeeById')->with($id)->willReturn(null);
        $this->responseMock->method('error')->willReturn('error');

        $result = $this->controller->updateEmployee($id);
        $this->assertEquals('error', $result);
    }

    public function testDeleteEmployeeSuccess()
    {
        $id = 1;
        $record = ['id' => $id, 'name' => 'John Doe'];
        $this->employeeModelMock->method('getEmployeeById')->with($id)->willReturn($record);
        $this->employeeModelMock->expects($this->once())->method('deleteEmployee')->with($id);
        $this->responseMock->method('success')->willReturn('success');

        $result = $this->controller->deleteEmployee($id);
        $this->assertEquals('success', $result);
    }

    public function testDeleteEmployeeNotFound()
    {
        $id = 999;
        $this->employeeModelMock->method('getEmployeeById')->with($id)->willReturn(null);
        $this->responseMock->method('error')->willReturn('error');

        $result = $this->controller->deleteEmployee($id);
        $this->assertEquals('error', $result);
    }
}
