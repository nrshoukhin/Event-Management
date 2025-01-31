<?php

class UserModel extends Model {
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE LOWER(email) = LOWER(?)");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($email, $password, $first_name, $last_name) {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)");
            $stmt->execute([$email, $password, $first_name, $last_name]);
            return true;
        } catch (PDOException $e) {
            return false; // Handle database-related errors
        }
    }
}
