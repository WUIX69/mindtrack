<?php

namespace Mindtrack\Models;

use PDO;
use PDOException;

class Services
{
    private static $conn;

    private static function conn()
    {
        if (!isset(self::$conn)) {
            global $conn;
            self::$conn = $conn;
        }
        return self::$conn;
    }

    public static function all()
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM services');
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Services fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Services fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function single($uuid = null)
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM services WHERE uuid=? LIMIT 1');
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Service fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Service fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function store($data = [])
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO services (
                    uuid, 
                    category_id,
                    name, 
                    description, 
                    status,
                    price, 
                    duration
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?
                )
            ");

            $stmt->execute([
                $data['uuid'],
                $data['category_id'],
                $data['name'],
                $data['description'],
                $data['status'],
                $data['price'],
                $data['duration']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Service created successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Service creation failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function update($data = [])
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE services SET 
                    category_id=?,
                    name=?, 
                    description=?, 
                    status=?,
                    price=?, 
                    duration=?,
                    updated_at=NOW()
                WHERE uuid=?
            ");

            $stmt->execute([
                $data['category_id'],
                $data['name'],
                $data['description'],
                $data['status'],
                $data['price'],
                $data['duration'],
                $data['uuid']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Service updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return 0;
        }
    }

    public static function delete($uuid = null)
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare('DELETE FROM services WHERE uuid=?');
            $stmt->execute([$uuid]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Service deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Service deletion failed: ' . $e->getMessage(),
            ];
        }
    }
}