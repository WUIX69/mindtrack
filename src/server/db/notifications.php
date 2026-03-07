<?php

namespace Mindtrack\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Notifications extends Base
{
    /**
     * Fetch all notifications for a specific user, ordered by newest first.
     */
    public static function allWhereUser(string $userUuid)
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM notifications WHERE user_uuid = ? ORDER BY created_at DESC');
            $stmt->execute([$userUuid]);
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

    /**
     * Count unread notifications for a specific user.
     */
    public static function countUnread(string $userUuid)
    {
        try {
            $stmt = self::conn()->prepare("SELECT COUNT(*) as unread FROM notifications WHERE user_uuid = ? AND is_read = 0");
            $stmt->execute([$userUuid]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int) ($result['unread'] ?? 0);
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Store a new notification.
     */
    public static function store(array $data)
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO notifications (
                    user_uuid, 
                    type,
                    data
                ) VALUES (
                    ?, ?, ?
                )
            ");

            $stmt->execute([
                $data['user_uuid'],
                $data['type'],
                $data['data']
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

    /**
     * Mark a single notification as read.
     */
    public static function updateWhereRead(int $id)
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE notifications SET 
                    is_read = 1
                WHERE id = ?
            ");

            $stmt->execute([$id]);

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

    /**
     * Mark all notifications as read for a specific user.
     */
    public static function updateAllWhereRead(string $userUuid)
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE notifications SET 
                    is_read = 1
                WHERE user_uuid = ? AND is_read = 0
            ");

            $stmt->execute([$userUuid]);

            self::commit();
            return [
                'success' => true,
                'message' => 'All notifications updated (READ) successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'All notifications (READ) update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete a notification.
     */
    public static function delete(int $id)
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->execute([$id]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Notification deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Notification deletion failed: ' . $e->getMessage(),
            ];
        }
    }
}
