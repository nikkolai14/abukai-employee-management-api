<?php

namespace App\Core;

use PDO;

class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    /**
     * Database constructor.
     *
     * @param array $config Database configuration with keys: host, dbname, username, password, charset.
     */
    public function __construct(array $config) {
        $this->host = $config['host'];
        $this->db = $config['dbname'];
        $this->user = $config['username'];
        $this->pass = $config['password'];
        $this->charset = $config['charset'];
        $this->connect();
    }

    /**
     * Establish a PDO database connection using the provided configuration.
     *
     * @throws \PDOException If the connection fails.
     * @return void
     */
    private function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Prepare and execute an SQL query with optional parameters.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Parameters to bind to the query.
     * @return \PDOStatement The executed PDO statement.
     */
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Fetch all rows from a query result as an array.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Parameters to bind to the query.
     * @return array The result set as an array.
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Fetch a single row from a query result.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Parameters to bind to the query.
     * @return mixed The first row of the result set or false if none.
     */
    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    /**
     * Execute an SQL statement and return the number of affected rows.
     *
     * @param string $sql The SQL statement to execute.
     * @param array $params Parameters to bind to the statement.
     * @return int The number of affected rows.
     */
    public function execute($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
}