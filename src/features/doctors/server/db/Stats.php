<?php

declare(strict_types=1);

namespace Mindtrack\Features\Doctors\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Stats extends Base
{
    /**
     * Get capacity overview metrics.
     * 
     * @return array
     */
    public static function getCapacityOverview(): array
    {
        try {
            $conn = self::conn();

            // Total active doctors
            $stmt = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'doctor' AND status = 'active'");
            $activeDoctors = (int) $stmt->fetchColumn();

            if ($activeDoctors === 0) {
                return [
                    'success' => true,
                    'message' => 'Capacity overview fetched successfully.',
                    'data' => [
                        'percentage' => 0,
                        'status' => 'No active doctors',
                        'bar_count' => 0
                    ]
                ];
            }

            // Patients currently assigned to active doctors
            // Using appointments table as a proxy for assigned patients
            $stmt = $conn->query("
                SELECT COUNT(DISTINCT patient_uuid) 
                FROM appointments 
                WHERE doctor_uuid IN (SELECT uuid FROM users WHERE role = 'doctor' AND status = 'active')
                AND status IN ('confirmed', 'completed', 'pending')
            ");
            $activePatients = (int) $stmt->fetchColumn();

            // Optimal target: 20 patients per active doctor
            $optimalCapacityPerDoctor = 20;
            $maxCapacity = $activeDoctors * $optimalCapacityPerDoctor;

            $utilization = ($activePatients / $maxCapacity) * 100;
            $percentage = min(100, (int) round($utilization)); // Cap at 100% for bar UI sanity if needed, or leave un-capped if they can exceed.

            // Determine status text and color hint
            $statusText = 'optimal';
            if ($utilization > 90) {
                $statusText = 'over capacity';
            } elseif ($utilization > 75) {
                $statusText = 'high utilization';
            }

            return [
                'success' => true,
                'message' => 'Capacity overview fetched successfully.',
                'data' => [
                    'percentage' => (int) round($utilization),
                    'status' => $statusText,
                    'bar_count' => 7 // Visual bars to render
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Doctor Stats::getCapacityOverview): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch capacity overview.',
            ];
        }
    }

    /**
     * Get specialty distribution map.
     * 
     * @return array
     */
    public static function getSpecialtyDistribution(): array
    {
        try {
            $conn = self::conn();

            // Total active doctors with a specialty
            $stmt = $conn->query("
                SELECT COUNT(u.uuid) 
                FROM users u
                JOIN user_doctor_info di ON u.uuid = di.user_uuid
                JOIN specializations s ON di.specialization_id = s.id
                WHERE u.role = 'doctor' AND u.status = 'active'
            ");
            $totalActiveWithSpecialty = (int) $stmt->fetchColumn();

            if ($totalActiveWithSpecialty === 0) {
                return [
                    'success' => true,
                    'message' => 'Specialty distribution fetched successfully.',
                    'data' => []
                ];
            }

            // Top 3 specialties by doctor count
            $stmt = $conn->query("
                SELECT s.name as specialty, COUNT(u.uuid) as doc_count
                FROM users u
                JOIN user_doctor_info di ON u.uuid = di.user_uuid
                JOIN specializations s ON di.specialization_id = s.id
                WHERE u.role = 'doctor' AND u.status = 'active'
                GROUP BY s.id
                ORDER BY doc_count DESC
                LIMIT 3
            ");
            $topSpecialties = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Assign colors matching UI elements
            $colors = ['primary', 'blue-500', 'success'];
            $distributions = [];

            foreach ($topSpecialties as $index => $row) {
                $percentage = (int) round(($row['doc_count'] / $totalActiveWithSpecialty) * 100);
                $distributions[] = [
                    'specialty' => $row['specialty'],
                    'percentage' => $percentage,
                    'color' => $colors[$index] ?? 'muted',
                ];
            }

            return [
                'success' => true,
                'message' => 'Specialty distribution fetched successfully.',
                'data' => $distributions
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Doctor Stats::getSpecialtyDistribution): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch specialty distribution.',
            ];
        }
    }
}
