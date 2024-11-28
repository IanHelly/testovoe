<?php

class Database
{
    private static ?Database $instance = null;

    private PDO $connection;

    public function getConnection(): PDO {
        return $this->connection;
    }

    private function __construct()
    {
        $host = 'localhost';
        $dbname = 'testmax';
        $username = 'root';
        $password = 'root';

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

}
