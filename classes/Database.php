<?php

class Database {
    protected $connection;
    protected $statement;

    public function __construct($host = 'localhost', $dbname = 'subdiwise') {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;user=root;charset=utf8";
            $this->connection = new PDO($dsn);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function query($sql, $params = [])
    {
        $this->statement = $this->connection->prepare($sql);

        $this->statement->execute($params);

        return $this;
    }

    public function fetchAll($option = PDO::FETCH_ASSOC) {
        return $this->statement->fetchAll($option);
    }

    public function fetch() {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertedId() {
        return $this->connection->lastInsertId();
    }
}