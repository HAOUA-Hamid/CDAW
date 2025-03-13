<?php

class UserModel {

    public static function getAllUsers() {
        $pdo = DatabaseConnector::current();
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
