<?php

namespace Mindtrack\Features\Doctors\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Doctors extends Base
{
    /**
     * Get doctor counts grouped by status.
     * 
     * @param array $filters
     * @return array
     */
    public static function countWhereStatus($filters = [])
    {
        try {
            $query = "SELECT status, COUNT(*) as count FROM users WHERE role = 'doctor'";
            $params = [];

            // Add filters if needed (e.g. if we want counts filtered by search)
            if (!empty($filters['filter_specialty'])) {
                // This requires join, might be overkill for simple status counts unless requested
                // For now, let's keep it simple as per original code which just grouped by status
            }

            $query .= " GROUP BY status";

            $stmt = self::conn()->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error (Doctors::countWhereStatus): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get top specialties by doctor count.
     * 
     * @return array
     */
    public static function countWhereSpecialty()
    {
        try {
            $query = "
                SELECT s.name, COUNT(*) as count
                FROM users u 
                JOIN user_doctor_info di ON u.uuid = di.user_uuid
                LEFT JOIN specializations s ON di.specialization_id = s.id
                WHERE u.role = 'doctor' AND u.status = 'active'
                GROUP BY s.name
                ORDER BY count DESC
                LIMIT 5
            ";

            $stmt = self::conn()->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error (Doctors::countWhereSpecialty): " . $e->getMessage());
            return [];
        }
    }
}
