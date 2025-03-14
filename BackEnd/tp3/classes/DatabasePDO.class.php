<?php
class DatabasePDO extends PDO {

    protected static $singleton = NULL;

    public static function singleton() {
        if (is_null(static::$singleton)) {
            static::$singleton = new static();
        }
        return static::$singleton;
    }

    public function __construct() {
        // Build the DSN (Data Source Name) for MySQL
        $connectionString = "mysql:host=" . DB_HOST;

        if (defined('DB_PORT')) {
            $connectionString .= ";port=" . DB_PORT;
        }

        $connectionString .= ";dbname=" . DB_DATABASE;
        $connectionString .= ";charset=utf8";

        // Initialize PDO with connection string, username, and password
        parent::__construct($connectionString, DB_USERNAME, DB_PASSWORD);

        // Set PDO to throw exceptions on errors
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}