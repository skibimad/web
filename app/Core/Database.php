<?php

namespace App\Core;

/**
 * Database connection singleton
 */
class Database
{
    private static $instance = null;
    private $connection;
    
    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        
        try {
            if ($config['driver'] === 'sqlite') {
                $dsn = "sqlite:{$config['database']}";
                $this->connection = new \PDO(
                    $dsn,
                    null,
                    null,
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } else {
                $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
                $this->connection = new \PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            }
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection(): \PDO
    {
        return $this->connection;
    }
    
    public function getPdo(): \PDO
    {
        return $this->connection;
    }
    
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    // Prevent cloning
    private function __clone() {}
    
    // Prevent unserialization
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
