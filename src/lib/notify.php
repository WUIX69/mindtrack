<?php

declare(strict_types=1);

namespace Mindtrack\Lib;

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
     * Send a notification to a user or admin.
     */
    public static function send()
    {
        return false;
    }

    /**
     * Get all notifications for the current user.
     *
     * @return array
     */
    public static function all()
    {
        return []; // Not implemented
    }

    /**
     * Clear all notifications for the current user.
     */
    public static function clear()
    {
        return false; // Not implemented
    }
}