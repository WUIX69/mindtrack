<?php

declare(strict_types=1);

namespace Mindtrack\Features\Notes\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Insights extends Base
{
    /**
     * Get 3 core insights for the patient notes page:
     * - Most Recent Diagnosis (from latest signed clinical note assessment)
     * - Treatment Adherence (% of total notes that are signed)
     * - Session Attendance (% of completed appointments vs total non-cancelled appointments)
     *
     * @param string $patientUuid
     * @return array
     */
    public static function getPatientInsights(string $patientUuid): array
    {
        try {
            $conn = self::conn();

            // 1. Most Recent Diagnosis (Service name from latest signed note)
            $stmt = $conn->prepare("
                SELECT s.name as service_name, c.updated_at 
                FROM clinical_notes c
                JOIN appointments a ON c.appointment_uuid = a.uuid
                JOIN services s ON a.service_uuid = s.uuid
                WHERE c.patient_uuid = ? AND c.status = 'signed' 
                ORDER BY c.updated_at DESC 
                LIMIT 1
            ");
            $stmt->execute([$patientUuid]);
            $recentNote = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Treatment Adherence (% of signed notes)
            $stmt = $conn->prepare("
                SELECT 
                    SUM(CASE WHEN status = 'signed' THEN 1 ELSE 0 END) as signed_notes,
                    COUNT(*) as total_notes
                FROM clinical_notes 
                WHERE patient_uuid = ?
            ");
            $stmt->execute([$patientUuid]);
            $adherenceData = $stmt->fetch(PDO::FETCH_ASSOC);

            $adherencePercentage = 0;
            if ($adherenceData['total_notes'] > 0) {
                $adherencePercentage = round(($adherenceData['signed_notes'] / $adherenceData['total_notes']) * 100);
            }

            // 3. Session Attendance (% of completed appointments vs total valid appointments)
            $stmt = $conn->prepare("
                SELECT 
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_appointments,
                    SUM(CASE WHEN status IN ('pending', 'confirmed', 'completed', 'rescheduled') THEN 1 ELSE 0 END) as total_valid_appointments
                FROM appointments 
                WHERE patient_uuid = ? AND sched_date <= CURDATE()
            ");
            $stmt->execute([$patientUuid]);
            $attendanceData = $stmt->fetch(PDO::FETCH_ASSOC);

            $attendancePercentage = 0;
            if ($attendanceData['total_valid_appointments'] > 0) {
                $attendancePercentage = round(($attendanceData['completed_appointments'] / $attendanceData['total_valid_appointments']) * 100);
            }

            // Format Diagnosis
            $formattedDiagnosis = null;
            if ($recentNote && !empty(trim($recentNote['service_name'] ?? ''))) {
                $dt = new \DateTime($recentNote['updated_at']);
                $formattedDiagnosis = [
                    'text' => trim($recentNote['service_name']),
                    'date_formatted' => $dt->format('M j, Y')
                ];
            }

            return [
                'success' => true,
                'message' => 'Insights fetched successfully.',
                'data' => [
                    'recent_diagnosis' => $formattedDiagnosis,
                    'adherence_percentage' => $adherencePercentage,
                    'attendance_percentage' => $attendancePercentage
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Insights::getPatientInsights): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch insights: ' . $e->getMessage(),
            ];
        }
    }
}
