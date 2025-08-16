<?php

namespace App\Models;

use App\Core\Database;

class BaseModel {
    protected $db;

    /**
     * BaseModel constructor.
     * @param Database $db Database instance.
     */
    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Execute a SQL query with optional parameters and return the result.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters for the query.
     * @return mixed The result of the query.
     */
    protected function query($sql, $params = []) {
        return $this->db->query($sql, $params);
    }

    /**
     * Fetch all rows from a SQL query as an array.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters for the query.
     * @return array The fetched rows as an array.
     */
    protected function fetchAll($sql, $params = []) {
        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Fetch a single row from a SQL query as an array.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters for the query.
     * @return array|null The fetched row as an array, or null if not found.
     */
    protected function fetch($sql, $params = []) {
        return $this->db->fetch($sql, $params);
    }

    /**
     * Execute a SQL statement (such as INSERT, UPDATE, DELETE).
     *
     * @param string $sql The SQL statement to execute.
     * @param array $params Optional parameters for the statement.
     * @return bool True on success, false on failure.
     */
    protected function execute($sql, $params = []) {
        return $this->db->execute($sql, $params);
    }

    /**
     * Map a row (array) to an object using the provided columns.
     *
     * @param array $row
     * @param array $columns
     * @return object
     */
    protected function mapRowToObject($row, $columns) {
        $obj = new \stdClass();
        foreach ($columns as $col) {
            $obj->{$col} = isset($row[$col]) ? $row[$col] : null;
        }
        return $obj;
    }
}