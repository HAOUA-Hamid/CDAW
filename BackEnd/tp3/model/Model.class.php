<?php
class Model {

    protected $props;

    public function __construct($props = array()) {
        $this->props = $props;
    }

    public function __get($prop) {
        return $this->props[$prop] ?? null; // Return null if property doesn’t exist
    }

    public function __set($prop, $val) {
        $this->props[$prop] = $val;
    }

    protected static function db() {
        return DatabasePDO::singleton();
    }

    // Store named SQL queries
    protected static $requests = array();

    public static function addSqlQuery($key, $sql) {
        static::$requests[$key] = $sql;
    }

    public static function sqlQueryNamed($key) {
        if (!isset(static::$requests[$key])) {
            throw new Exception("SQL query '$key' not defined for " . static::class);
        }
        return static::$requests[$key];
    }

    protected static function query($sql) {
        try {
            $st = static::db()->query($sql);
            $st->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class());
            return $st;
        } catch (PDOException $e) {
            die("SQL query error: " . $e->getMessage() . " - Query: " . $sql);
        }
    }

    protected static function exec($sqlKey, $values = array()) {
        try {
            $sth = static::db()->prepare(static::sqlQueryNamed($sqlKey));
            $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class());
            $sth->execute($values);
            return $sth;
        } catch (PDOException $e) {
            die("SQL execution error: " . $e->getMessage() . " - Query: " . static::sqlQueryNamed($sqlKey));
        }
    }
}