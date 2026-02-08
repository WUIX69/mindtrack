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
    protected static function conn()
    {
        if (!isset(self::$conn)) {
            // Load environment variables if not already loaded (though app.php usually handles this)
            if (!isset($_ENV['DB_HOST'])) {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../../..');
                $dotenv->safeLoad();
            }

            try {
                self::$conn = new PDO(
                    "mysql:host=" . $_ENV['DB_HOST'] .
                    ";dbname=" . $_ENV['DB_DATABASE'] .
                    ";port=" . ($_ENV['DB_PORT'] ?? 3306),
                    $_ENV['DB_USERNAME'],
                    $_ENV['DB_PASSWORD']
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
