<?php

namespace Mindtrack\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Specialization extends Base
{

    /**
     * Get all specializations.
     * 
     * @return array
     */
    public static function all()
    {
        try {
            $query = "SELECT * FROM specializations ORDER BY name ASC";
            $stmt = self::conn()->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Specializations fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::all): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Specialization fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function findByName($name)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM specializations WHERE name = ? LIMIT 1");
            $stmt->execute([$name]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::findByName): " . $e->getMessage());
            return null;
        }
    }

    public static function create($name)
    {
        try {
            $stmt = self::conn()->prepare("INSERT INTO specializations (name) VALUES (?)");
            $stmt->execute([$name]);
            return self::conn()->lastInsertId();
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::create): " . $e->getMessage());
            return null;
        }
    }

}
