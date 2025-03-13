<?php

class UserModel {
    public static function getAllUsers() {
        $pdo = DatabaseConnector::current();
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUserById($id) {
        $pdo = DatabaseConnector::current();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createUser($name, $email) {
        $pdo = DatabaseConnector::current();
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
        return $pdo->lastInsertId();
    }

    public static function updateUser($id, $name, $email) {
        $pdo = DatabaseConnector::current();
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public static function deleteUser($id) {
        $pdo = DatabaseConnector::current();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
    
}
?>
