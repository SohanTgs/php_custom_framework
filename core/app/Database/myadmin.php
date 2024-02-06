<?php

namespace App\Database;

use PDO;

class Database {
    private static $connection;

    public function __construct() {   
        if (!self::$connection) { 
            $host = 'localhost';
            $port = 3306;
            $database = 'raw_php';
            $username = 'root';
            $password = '';

            self::$connection = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }

    public static function select($query, $bindings = []) {
        $statement = self::$connection->prepare($query);
        $statement->execute($bindings);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($query, $bindings = []) {
        $statement = self::$connection->prepare($query);
        $statement->execute($bindings);
        return self::$connection->lastInsertId();
    }
}
