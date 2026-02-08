<?php

namespace Mindtrack\Core;

use PDO;
use PDOException;

abstract class BaseModel
{
    protected static $conn;

    /**
     * Get the database connection
     */
    protected static function conn()
    {
        if (!isset(static::$conn)) {
            global $conn;
            static::$conn = $conn;
        }
        return static::$conn;
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
        return self::conn()->rollBack();
    }
}
