<?php

class DatabaseConnector {

    protected static $pdo = NULL;

    public static function current() {
        if (is_null(static::$pdo)) {
            static::createPDO();
        }
        return static::$pdo;
    }

    protected static function createPDO() {
        $connectionString = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE;
        if (defined('DB_PORT')) {
            $connectionString .= ";port=" . DB_PORT;
        }

        static::$pdo = new PDO($connectionString, DB_USERNAME, DB_PASSWORD);
        static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
