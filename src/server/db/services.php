<?php

namespace Mindtrack\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Services extends Base
{
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

    public static function countWhereStatuses()
    {
        try {
            $stmt = self::conn()->query("
                SELECT 
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive
                FROM services
            ");

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'active' => (int) ($result['active'] ?? 0),
                'inactive' => (int) ($result['inactive'] ?? 0)
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'active' => 0,
                'inactive' => 0
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
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO services (
                    uuid, 
                    category_id,
                    name, 
                    description, 
                    status,
                    price, 
                    duration,
                    specialization_id
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?
                )
            ");

            $stmt->execute([
                $data['uuid'],
                $data['category_id'],
                $data['name'],
                $data['description'],
                $data['status'],
                $data['price'],
                $data['duration'],
                $data['specialization_id'] ?? null
            ]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Service created successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Service creation failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function update($data = [])
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE services SET 
                    category_id=?,
                    name=?, 
                    description=?, 
                    status=?,
                    price=?, 
                    duration=?,
                    specialization_id=?,
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
                $data['specialization_id'] ?? null,
                $data['uuid']
            ]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Service updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return 0;
        }
    }

    public static function delete($uuid = null)
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare('DELETE FROM services WHERE uuid=?');
            $stmt->execute([$uuid]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Service deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Service deletion failed: ' . $e->getMessage(),
            ];
        }
    }
}
