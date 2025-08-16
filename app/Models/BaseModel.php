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

    protected function query($sql, $params = []) {
        return $this->db->query($sql, $params);
    }

    protected function fetchAll($sql, $params = []) {
        return $this->db->fetchAll($sql, $params);
    }

    protected function fetch($sql, $params = []) {
        return $this->db->fetch($sql, $params);
    }

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