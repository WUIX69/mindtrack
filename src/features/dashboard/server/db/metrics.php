<?php

declare(strict_types=1);

namespace Mindtrack\Features\Dashboard\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Metrics extends Base
{
    /**
     * Get 3 core metrics for the patient dashboard:
     * - Next upcoming appointment
     * - Total completed sessions
     * - Total distinct providers seen
     *
     * @param string $patientUuid
     * @return array
     */
    public static function getPatientMetrics(string $patientUuid): array
    {
        try {
            $conn = self::conn();

            // 1. Upcoming Appointment
            $stmt = $conn->prepare("
                SELECT 
                    a.sched_date,
                    a.sched_time,
                    s.name as service_name,
                    CONCAT(d.firstname, ' ', d.lastname) as doctor_name
                FROM appointments a
                JOIN services s ON a.service_uuid = s.uuid
                JOIN users d ON a.doctor_uuid = d.uuid
                WHERE a.patient_uuid = ? 
                AND a.status IN ('pending', 'confirmed', 'rescheduled')
                AND a.sched_date >= CURDATE()
                ORDER BY a.sched_date ASC, a.sched_time ASC
                LIMIT 1
            ");
            $stmt->execute([$patientUuid]);
            $upcomingApt = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Completed Sessions Count
            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM appointments 
                WHERE patient_uuid = ? AND status = 'completed'
            ");
            $stmt->execute([$patientUuid]);
            $completedSessions = (int) $stmt->fetchColumn();

            // 3. Total Distinct Providers Seen
            $stmt = $conn->prepare("
                SELECT COUNT(DISTINCT doctor_uuid) FROM appointments 
                WHERE patient_uuid = ? AND status = 'completed'
            ");
            $stmt->execute([$patientUuid]);
            $totalProviders = (int) $stmt->fetchColumn();

            // Format Upcoming Appointment Date (e.g., Oct 24, 2:00 PM)
            $formattedUpcoming = null;
            if ($upcomingApt) {
                // Combine date and time
                $datetimeStr = $upcomingApt['sched_date'] . ' ' . $upcomingApt['sched_time'];
                $dt = new \DateTime($datetimeStr);

                // Calculate days from now
                $now = new \DateTime();
                $now->setTime(0, 0, 0);
                $aptDate = (clone $dt)->setTime(0, 0, 0);
                $diffDays = $now->diff($aptDate)->days;
                $invert = $now->diff($aptDate)->invert;

                $relativeText = 'Today';
                if ($invert === 0 && $diffDays > 0) {
                    $relativeText = $diffDays === 1 ? 'Tomorrow' : "In {$diffDays} days";
                }

                $formattedUpcoming = [
                    'datetime_formatted' => $dt->format('M j, g:i A'),
                    'relative_text' => $relativeText,
                    'service_name' => $upcomingApt['service_name'],
                    'doctor_name' => 'Dr. ' . ltrim($upcomingApt['doctor_name'], 'Dr. ')
                ];
            }

            return [
                'success' => true,
                'message' => 'Metrics fetched successfully.',
                'data' => [
                    'upcoming_appointment' => $formattedUpcoming,
                    'completed_sessions' => $completedSessions,
                    'total_providers' => $totalProviders
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Metrics::getPatientMetrics): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch metrics: ' . $e->getMessage(),
            ];
        }
    }
}
