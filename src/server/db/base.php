<?php

namespace Mindtrack\Server\Db;

use PDO;
use PDOException;
use Dotenv\Dotenv;

abstract class Base
{
    protected static $conn;

    /**
     * Get the database connection (Lazy Loading)
     */
    public static function conn()
    {
        global $config;

        if (!isset(self::$conn)) {
            $dbConfig = $config['db'][$config['env']];
            try {
                self::$conn = new PDO(
                    "mysql:host=" . $dbConfig['host'] .
                    ";dbname=" . $dbConfig['name'] .
                    ";port=" . $dbConfig['port'],
                    $dbConfig['username'],
                    $dbConfig['password']
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Connection failed: " . $e->getMessage());
                die("Database connection failed. Please check logs.");
            }
        }
        return self::$conn;
    }

    /**
     * Begin a transaction
     */
    protected static function beginTransaction()
    {
        return self::conn()->beginTransaction();
    }

    /**
     * Commit a transaction
     */
    protected static function commit()
    {
        return self::conn()->commit();
    }

    /**
     * Rollback a transaction
     */
    protected static function rollBack()
    {
        // Check if transaction is active before rollback to avoid errors
        if (self::conn()->inTransaction()) {
            return self::conn()->rollBack();
        }
        return false;
    }
}
