<?php

namespace VetSync\Models;

use PDO;
use PDOException;

class Products
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
            $stmt = self::conn()->prepare('SELECT * FROM products');
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Products fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Products fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function single($uuid = null)
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM products WHERE uuid=? LIMIT 1');
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Product fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Product fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function store($data = [])
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO products (
                    uuid, 
                    category_id,
                    name, 
                    description, 
                    status,
                    og_price, 
                    dc_price,
                    stock,
                    tags,
                    specs
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )
            ");

            $stmt->execute([
                $data['uuid'],
                $data['category_id'],
                $data['name'],
                $data['description'],
                $data['status'],
                $data['og_price'],
                $data['dc_price'],
                $data['stock'],
                $data['tags'],
                $data['specs']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Product created successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Product creation failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function update($data = [])
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE products SET 
                    category_id=?,
                    name=?, 
                    description=?, 
                    status=?,
                    og_price=?, 
                    dc_price=?,
                    stock=?,
                    tags=?,
                    specs=?,
                    updated_at=NOW()
                WHERE uuid=?
            ");

            $stmt->execute([
                $data['category_id'],
                $data['name'],
                $data['description'],
                $data['status'],
                $data['og_price'],
                $data['dc_price'],
                $data['stock'],
                $data['tags'],
                $data['specs'],
                $data['uuid']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Product updated successfully.',
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

            $stmt = self::conn()->prepare('DELETE FROM products WHERE uuid=?');
            $stmt->execute([$uuid]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Product deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Product deletion failed: ' . $e->getMessage(),
            ];
        }
    }
}