<?php

namespace Mindtrack\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Notifications extends Base
{
    public static function all()
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM notifications');
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Notifications fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Notifications fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function counts()
    {
        try {
            $stmt = self::conn()->query("
                SELECT 
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive
                FROM notifications
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

    public static function store($data = [])
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO notifications (
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
                'message' => 'Notification created successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Notification creation failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function updateWhereRead($uuid, $read_status = false)
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE notifications SET 
                    is_read=?
                WHERE uuid=?
            ");

            $stmt->execute([
                $read_status ? 1 : 0,
                $uuid
            ]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Notification updated (READ) successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Notification (READ) update failed: ' . $e->getMessage(),
            ];
        }
    }
}
