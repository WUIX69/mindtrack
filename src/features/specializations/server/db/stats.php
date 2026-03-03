<?php

declare(strict_types=1);

namespace Mindtrack\Features\Specializations\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Stats extends Base
{
    /**
     * Get specialization overview stats (total, active, recently updated, top capacity).
     * 
     * @return array
     */
    public static function getOverviewStats(): array
    {
        try {
            // Total Specializations
            $stmt = self::conn()->query("SELECT COUNT(id) as total FROM specializations");
            $total = (int) $stmt->fetchColumn();

            // Active Status
            $stmt = self::conn()->query("SELECT COUNT(id) as active_count FROM specializations WHERE status = 'active'");
            $active = (int) $stmt->fetchColumn();

            // Recently Updated (last 7 days)
            $stmt = self::conn()->query("SELECT COUNT(id) as recent FROM specializations WHERE updated_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
            $recent = (int) $stmt->fetchColumn();

            // Top Capacity
            $stmt = self::conn()->query("
                SELECT s.name 
                FROM specializations s
                JOIN user_doctor_info di ON s.id = di.specialization_id
                JOIN users u ON di.user_uuid = u.uuid
                WHERE u.status = 'active'
                GROUP BY s.id
                ORDER BY COUNT(u.uuid) DESC
                LIMIT 1
            ");
            $topCapacity = $stmt->fetchColumn() ?: 'None';

            return [
                'success' => true,
                'message' => 'Specialization stats fetched successfully.',
                'data' => [
                    'total_specializations' => $total,
                    'active_status' => $active,
                    'recently_updated' => $recent,
                    'top_capacity' => $topCapacity
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Stats::getOverviewStats): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch specialization stats.',
                'data' => [
                    'total_specializations' => 0,
                    'active_status' => 0,
                    'recently_updated' => 0,
                    'top_capacity' => 'N/A'
                ]
            ];
        }
    }
}
