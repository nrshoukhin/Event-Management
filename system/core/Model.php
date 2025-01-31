<?php

class Model {
    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO(DSN, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }
}
