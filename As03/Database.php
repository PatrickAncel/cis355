<?php
class Database
{
    private static $dbName = 'fake db name';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'fake username';
    private static $dbUserPassword = 'fake password';
    
    private static $cont = null;
    
    public function __construct() {
        die("Init function is not allowed");
    }
    
    public static function connect() {
        // Only connect if not yet connected.
        if (null == self::$cont) {
            try {
                self::$cont = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName,
                    self::$dbUsername, self::$dbUserPassword);
            }
            catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function disconnect() {
        self::$cont = null;
    }
}