<?php

class DatabaseUtil {

    private static $conn = null;

    public static function openConnection($dbName) {

        // Is a connection already open?
        if (self::$conn != null) {
            // Close it.
            self::closeConnection();
        }

        $username = "fake username";
        $password = "fake password";

        try {
            self::$conn = new PDO("mysql:host=localhost;dbname=$dbName", $username, $password);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

        return self::$conn;
    }

    public static function closeConnection() {
        self::$conn = null;
    }

}

?>