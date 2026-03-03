<?php

declare(strict_types=1);

namespace Mindtrack\Features\Dashboard\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class QuickStats extends Base
{
    public static function getAdminStats(): array
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT
                    (SELECT COUNT(*) FROM users WHERE role = 'patient') as total_patients,
                    (SELECT COUNT(*) FROM appointments WHERE status = 'pending') as pending_requests,
                    (SELECT COUNT(*) FROM users WHERE role = 'doctor' AND status = 'active') as active_providers,
                    (SELECT COUNT(*) FROM appointments 
                     WHERE status = 'completed' 
                     AND sched_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
                    ) as monthly_completed
            ");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'message' => 'Admin stats fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (QuickStats::getAdminStats): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch stats: ' . $e->getMessage(),
            ];
        }
    }
}
