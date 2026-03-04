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

    public static function getDoctorStats(string $doctorUuid): array
    {
        try {
            $conn = self::conn();

            // 1. Today's Sessions (Appointments scheduled for today for this doctor)
            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM appointments 
                WHERE doctor_uuid = ? AND sched_date = CURDATE()
            ");
            $stmt->execute([$doctorUuid]);
            $todaysSessions = (int) $stmt->fetchColumn();

            // 2. Pending Notes (Clinical notes in draft status by this doctor)
            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM clinical_notes 
                WHERE doctor_uuid = ? AND status = 'draft'
            ");
            $stmt->execute([$doctorUuid]);
            $pendingNotes = (int) $stmt->fetchColumn();

            // 3. Weekly Consultations (Completed appointments this week)
            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM appointments 
                WHERE doctor_uuid = ? AND status = 'completed' 
                AND YEARWEEK(sched_date, 1) = YEARWEEK(CURDATE(), 1)
            ");
            $stmt->execute([$doctorUuid]);
            $weeklyConsultations = (int) $stmt->fetchColumn();

            // 4. Weekly Hours (Sum of service duration for completed appointments this week)
            $stmt = $conn->prepare("
                SELECT SUM(s.duration) 
                FROM appointments a
                JOIN services s ON a.service_uuid = s.uuid
                WHERE a.doctor_uuid = ? AND a.status = 'completed' 
                AND YEARWEEK(a.sched_date, 1) = YEARWEEK(CURDATE(), 1)
            ");
            $stmt->execute([$doctorUuid]);
            $weeklyMinutes = (int) $stmt->fetchColumn();

            // Convert to hours with 1 decimal place max (e.g., 34.5)
            $weeklyHours = round($weeklyMinutes / 60, 1);

            return [
                'success' => true,
                'message' => 'Doctor stats fetched successfully.',
                'data' => [
                    'todays_sessions' => $todaysSessions,
                    'pending_notes' => $pendingNotes,
                    'weekly_consultations' => $weeklyConsultations,
                    'weekly_hours' => $weeklyHours
                ],
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (QuickStats::getDoctorStats): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch doctor stats: ' . $e->getMessage(),
            ];
        }
    }
}
