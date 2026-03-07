<?php

declare(strict_types=1);

namespace Mindtrack\Lib;

use Mindtrack\Server\Db\Notifications;
use PDO;
use PDOException;
use Pusher\Pusher;
use Pusher\PusherException;

class Notify
{

    private PDO $db;
    private Pusher $pusher;

    public function __construct(PDO $db)
    {
        $this->db = $db;

        $this->pusher = new Pusher(
            $_ENV['PUSHER_APP_KEY'],
            $_ENV['PUSHER_APP_SECRET'],
            $_ENV['PUSHER_APP_ID'],
            [
                'cluster' => $_ENV['PUSHER_APP_CLUSTER'],
                'useTLS' => true
            ]
        );
    }

    /**
     * Send a notification to a specific user.
     *
     * @param string $userUuid The recipient's UUID.
     * @param string $type     A short string identifier for the notification type.
     * @param array $data      Associative array for the notification body containing UI details like title, description.
     * @return bool            True on success, false on failure.
     */
    public function send(string $userUuid, string $type, array $data): bool
    {
        try {
            // 1. Insert into database
            $encodedData = json_encode($data, JSON_UNESCAPED_UNICODE);
            $result = Notifications::store([
                'user_uuid' => $userUuid,
                'type' => $type,
                'data' => $encodedData
            ]);

            if (!$result['success']) {
                return false;
            }

            // 2. Trigger Pusher event
            $this->pusher->trigger(
                'user-' . $userUuid,
                'notification.new',
                [
                    'type' => $type,
                    'data' => $data,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );

            return true;
        } catch (\Exception $e) {
            error_log("Notify Send Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all notifications for the current user.
     *
     * @param string $userUuid
     * @return array
     */
    public function getByUser(string $userUuid): array
    {
        $result = Notifications::allWhereUser($userUuid);
        return $result['success'] ? $result['data'] : [];
    }

    /**
     * Get unread count for the current user.
     *
     * @param string $userUuid
     * @return int
     */
    public function getUnreadCount(string $userUuid): int
    {
        return Notifications::countUnread($userUuid);
    }

    /**
     * Mark a single notification as read.
     *
     * @param int $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        $result = Notifications::updateWhereRead($id);
        return $result['success'];
    }

    /**
     * Mark all notifications as read for a user.
     *
     * @param string $userUuid
     * @return bool
     */
    public function markAllAsRead(string $userUuid): bool
    {
        $result = Notifications::updateAllWhereRead($userUuid);
        return $result['success'];
    }
}