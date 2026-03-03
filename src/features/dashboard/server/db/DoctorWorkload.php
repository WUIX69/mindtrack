<?php

declare(strict_types=1);

namespace Mindtrack\Features\Dashboard\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class DoctorWorkload extends Base
{
    public static function getTodayWorkload(): array
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT 
                    u.uuid,
                    u.firstname,
                    u.lastname,
                    di.availability,
                    COUNT(a.uuid) as appointments_today,
                    COALESCE(SUM(s.duration), 0) as total_duration_minutes
                FROM users u
                LEFT JOIN user_doctor_info di ON u.uuid = di.user_uuid
                LEFT JOIN appointments a 
                    ON a.doctor_uuid = u.uuid 
                    AND a.sched_date = CURDATE()
                    AND a.status NOT IN ('cancelled', 'no_show')
                LEFT JOIN services s ON a.service_uuid = s.uuid
                WHERE u.role = 'doctor' AND u.status = 'active'
                GROUP BY u.uuid, u.firstname, u.lastname, di.availability
                ORDER BY appointments_today DESC, u.lastname ASC
            ");
            $stmt->execute();
            $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            $dayMap = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            $currentDay = $dayMap[(int) date('w')];

            $result = [];
            foreach ($doctors as $doctor) {
                $availableMinutes = self::calculateAvailableMinutes($doctor['availability'], $currentDay);
                $totalDuration = (int) $doctor['total_duration_minutes'];

                $workloadPercent = 0;
                if ($availableMinutes > 0) {
                    $workloadPercent = min(100, (int) round(($totalDuration / $availableMinutes) * 100));
                }

                $result[] = [
                    'uuid' => $doctor['uuid'],
                    'doctor_name' => $doctor['firstname'] . ' ' . $doctor['lastname'],
                    'appointments_today' => (int) $doctor['appointments_today'],
                    'total_duration_minutes' => $totalDuration,
                    'available_minutes' => $availableMinutes,
                    'workload_percent' => $workloadPercent,
                ];
            }

            return [
                'success' => true,
                'message' => 'Doctor workload fetched successfully.',
                'data' => $result,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (DoctorWorkload::getTodayWorkload): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch workload: ' . $e->getMessage(),
            ];
        }
    }

    private static function calculateAvailableMinutes(?string $availabilityJson, string $currentDay): int
    {
        if (empty($availabilityJson)) {
            return 480; // HACK: default 8-hour day when no availability is set
        }

        $availability = json_decode($availabilityJson, true);
        if (!is_array($availability) || !isset($availability[$currentDay])) {
            return 480;
        }

        $daySchedule = $availability[$currentDay];

        $isActive = $daySchedule['active'] ?? false;
        if ($isActive === false || $isActive === '0' || $isActive === 0) {
            return 0;
        }

        $start = $daySchedule['start'] ?? '09:00';
        $end = $daySchedule['end'] ?? '17:00';

        $startMinutes = self::timeToMinutes($start);
        $endMinutes = self::timeToMinutes($end);

        $diff = $endMinutes - $startMinutes;
        return max(0, $diff);
    }

    private static function timeToMinutes(string $time): int
    {
        $parts = explode(':', $time);
        return ((int) $parts[0] * 60) + (int) ($parts[1] ?? 0);
    }
}
