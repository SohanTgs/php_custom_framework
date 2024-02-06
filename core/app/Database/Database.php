<?php

namespace App\Database;

use PDO;

class Database
{
    public $connection;
    public $table_prefix;
    public static $queries = [];

    public function __construct()
    {  
        global $table_prefix;
        $this->table_prefix = $table_prefix;

        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        $this->connection = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function tablePrefix()
    {
        return $this->table_prefix;
    }

    public function execute($sql)
    {
        $sql = $this->setPrefix($sql);
        self::$queries[] = $sql;
    
        $statement = $this->connection->query($sql);
    
        $this->throwException();
    
        if ($statement !== false) {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $this->connection->exec($sql);
        }
    
        return $result;
    }

    public function getRow($sql)
    {
        $sql = $this->setPrefix($sql);
        self::$queries[] = $sql;
    
        $statement = $this->connection->query($sql);
    
        // Check for errors
        $this->throwException();
    
        // Fetch a single row for SELECT queries
        $result = $statement !== false ? $statement->fetch(PDO::FETCH_ASSOC) : null;
    
        return $result;
    }
    

    public function getVar($sql)
    {
        $sql = $this->setPrefix($sql);
        self::$queries[] = $sql;
        $result = $this->wpdb->get_var($sql);
        $this->throwException();
        return $result;
    }

    public function query($sql)
    {
        $sql = $this->setPrefix($sql);
        self::$queries[] = $sql;
        $this->wpdb->query($sql);
        $this->throwException();
        return $this->wpdb->insert_id;
    }

    public function getAllQueries()
    {
        return self::$queries;
    }

    private function setPrefix($sql)
    {
        return str_replace("{{table_prefix}}",$this->table_prefix,$sql);
    }

    private function throwException()
    {
        if ($this->connection->errorCode() !== '00000') {
            $errorInfo = $this->connection->errorInfo();
            $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : 'Unknown database error';
            throw new \Exception($errorMessage);
        }
    }
}