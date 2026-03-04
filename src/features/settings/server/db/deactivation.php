<?php
namespace Mindtrack\Features\Settings\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Deactivation extends Base
{
    public static function storeLog(string $uuid, string $reason, ?string $feedback)
    {
        try {
            self::beginTransaction();
            $stmt = self::conn()->prepare("
                INSERT INTO user_deactivation_logs (user_uuid, reason, feedback)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$uuid, $reason, $feedback]);
            self::commit();

            return [
                'success' => true,
                'message' => 'Deactivation reason logged.'
            ];
        } catch (PDOException $e) {
            self::rollBack();
            error_log("SQL Error (Deactivation::storeLog): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to log deactivation reason.'
            ];
        }
    }

    public static function deactivateUser(string $uuid)
    {
        try {
            self::beginTransaction();
            $stmt = self::conn()->prepare("
                UPDATE users SET status = 'inactive' WHERE uuid = ?
            ");
            $stmt->execute([$uuid]);
            self::commit();

            return [
                'success' => true,
                'message' => 'User deactivated successfully.'
            ];
        } catch (PDOException $e) {
            self::rollBack();
            error_log("SQL Error (Deactivation::deactivateUser): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to deactivate user.'
            ];
        }
    }
}
