<?php

namespace App\Models;

use App\Models\BaseModel;

class EmployeeModel extends BaseModel {
    /**
     * Employee table columns
     */
    protected $col_id = 'id';
    protected $col_name = 'name';
    protected $col_email = 'email';
    protected $col_position = 'position';
    protected $col_salary = 'salary';
    protected $col_created_at = 'created_at';

    /**
     * Get all column names as an array
     *
     * @return array
     */
    public function getColumns() {
        return [
            $this->col_id,
            $this->col_name,
            $this->col_email,
            $this->col_position,
            $this->col_salary,
            $this->col_created_at
        ];
    }

    /**
     * Get all employees.
     *
     * @return array
     */
    public function getAllEmployees()
    {
        $columns = $this->getColumns();
        $columns_sql = implode(', ', $columns);
        $sql = "SELECT $columns_sql FROM employees";
        $rows = $this->fetchAll($sql);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->mapRowToObject($row, $columns);
        }

        return $result;
    }

    /**
     * Get an employee by ID.
     *
     * @param int $id
     * @return array|null
     */
    public function getEmployeeById($id)
    {
        $columns = $this->getColumns();
        $columns_sql = implode(', ', $columns);
        $sql = "SELECT $columns_sql FROM employees WHERE {$this->col_id} = :id";
        $params = ['id' => $id];
        $row = $this->fetch($sql, $params);

        if (!$row) return null;

        return $this->mapRowToObject($row, $columns);
    }

    /**
     * Get an employee by email.
     *
     * @param string $email
     * @return array|null
     */
    public function getEmployeeByEmail($email)
    {
        $columns = $this->getColumns();
        $columns_sql = implode(', ', $columns);
        $sql = "SELECT $columns_sql FROM employees WHERE {$this->col_email} = :email";
        $params = ['email' => $email];
        $row = $this->fetch($sql, $params);

        if (!$row) return null;

        return $this->mapRowToObject($row, $columns);
    }

    /**
     * Add a new employee.
     *
     * @param array $data
     * @return bool
     */
    public function addEmployee($data)
    {
        $sql = "INSERT INTO employees ({$this->col_name}, {$this->col_email}, {$this->col_position}, {$this->col_salary}) VALUES (:name, :email, :position, :salary)";
        return $this->execute($sql, $data);
    }

    /**
     * Update an existing employee.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateEmployee($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE employees SET {$this->col_name} = :name, {$this->col_email} = :email, {$this->col_position} = :position, {$this->col_salary} = :salary WHERE {$this->col_id} = :id";
        return $this->execute($sql, $data);
    }

    /**
     * Delete an employee by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteEmployee($id)
    {
        $sql = "DELETE FROM employees WHERE {$this->col_id} = :id";
        return $this->execute($sql, ['id' => $id]);
    }
}