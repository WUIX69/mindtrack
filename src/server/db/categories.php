<?php

namespace Mindtrack\Server\Db;

use PDO;
use PDOException;

class Categories
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

    public static function all($reference_model = null)
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM categories WHERE reference_model=?');
            $stmt->execute([$reference_model]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => $reference_model . ' categories fetched successfully',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $reference_model . ' categories fetch failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function single($id = null, $reference_model = null)
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM categories WHERE id=? AND reference_model=? LIMIT 1');
            $stmt->execute([$id, $reference_model]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => $reference_model . ' category fetched successfully',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $reference_model . ' category fetch failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function store($data = [])
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO categories (
                    reference_model, 
                    icon, 
                    name, 
                    description, 
                    status
                ) VALUES (
                    ?, ?, ?, ?, ?
                )
            ");

            $stmt->execute([
                $data['reference_model'],
                $data['icon'],
                $data['name'],
                $data['description'],
                $data['status']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => $data['reference_model'] . ' category created successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => $data['reference_model'] . ' category creation failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function update($data = [])
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE categories SET 
                    icon=?, 
                    name=?, 
                    description=?, 
                    status=?
                WHERE id=? AND reference_model=?
            ");

            $stmt->execute([
                $data['icon'],
                $data['name'],
                $data['description'],
                $data['status'],
                $data['id'],
                $data['reference_model']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => $data['reference_model'] . ' category updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => $data['reference_model'] . ' category update failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function delete($id = null, $reference_model = null)
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare('DELETE FROM categories WHERE id=? AND reference_model=?');
            $stmt->execute([$id, $reference_model]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => $reference_model . ' category deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => $reference_model . ' category deletion failed: ' . $e->getMessage(),
            ];
        }
    }
}