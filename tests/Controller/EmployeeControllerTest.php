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
}
