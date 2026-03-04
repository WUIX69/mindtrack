<?php

declare(strict_types=1);

namespace Mindtrack\Features\Dashboard\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class RecentPatientActivity extends Base
{
    /**
     * Get the 5 most recent activities related to a doctor's patients.
     * Includes appointments and clinical notes.
     *
     * @param string $doctorUuid
     * @return array
     */
    public static function getDoctorRecentActivity(string $doctorUuid): array
    {
        try {
            $conn = self::conn();

            // We combine recent notes and recent appointments into a single feed
            // and sort them by the most recent timestamp.
            $stmt = $conn->prepare("
                (
                    SELECT 
                        'note' as type,
                        n.status as event_status,
                        n.updated_at as event_time,
                        CONCAT(u.firstname, ' ', u.lastname) as patient_name
                    FROM clinical_notes n
                    JOIN users u ON n.patient_uuid = u.uuid
                    WHERE n.doctor_uuid = ?
                )
                UNION ALL
                (
                    SELECT 
                        'appointment' as type,
                        a.status as event_status,
                        a.updated_at as event_time,
                        CONCAT(u.firstname, ' ', u.lastname) as patient_name
                    FROM appointments a
                    JOIN users u ON a.patient_uuid = u.uuid
                    WHERE a.doctor_uuid = ?
                )
                ORDER BY event_time DESC
                LIMIT 5
            ");

            $stmt->execute([$doctorUuid, $doctorUuid]);
            $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Format the raw data into UI-friendly readouts
            $formattedData = [];
            foreach ($activities as $act) {
                $timeDiff = self::getTimeDiff($act['event_time']);

                $item = [
                    'patient_name' => $act['patient_name'],
                    'time_ago' => $timeDiff,
                    'raw_time' => $act['event_time']
                ];

                if ($act['type'] === 'note') {
                    if ($act['event_status'] === 'signed') {
                        $item['title'] = 'Clinical Note Finalized';
                        $item['description'] = "Note signed and locked for {$act['patient_name']}";
                        $item['icon'] = 'done_all';
                        $item['color'] = 'emerald';
                    } else {
                        $item['title'] = 'Clinical Note Drafted';
                        $item['description'] = "Draft saved for {$act['patient_name']}";
                        $item['icon'] = 'edit_document';
                        $item['color'] = 'blue';
                    }
                } else {
                    // Appointment
                    if ($act['event_status'] === 'completed') {
                        $item['title'] = 'Session Completed';
                        $item['description'] = "Appointment marked complete for {$act['patient_name']}";
                        $item['icon'] = 'check_circle';
                        $item['color'] = 'emerald';
                    } elseif ($act['event_status'] === 'cancelled') {
                        $item['title'] = 'Session Cancelled';
                        $item['description'] = "Appointment cancelled by {$act['patient_name']}";
                        $item['icon'] = 'cancel';
                        $item['color'] = 'destructive';
                    } elseif ($act['event_status'] === 'no_show') {
                        $item['title'] = 'Missed Session';
                        $item['description'] = "{$act['patient_name']} did not attend";
                        $item['icon'] = 'priority_high';
                        $item['color'] = 'amber';
                    } elseif ($act['event_status'] === 'confirmed') {
                        $item['title'] = 'Session Confirmed';
                        $item['description'] = "Upcoming session confirmed for {$act['patient_name']}";
                        $item['icon'] = 'event_available';
                        $item['color'] = 'primary';
                    } else {
                        $item['title'] = 'Appointment Update';
                        $item['description'] = "Status changed to {$act['event_status']} for {$act['patient_name']}";
                        $item['icon'] = 'update';
                        $item['color'] = 'muted';
                    }
                }

                $formattedData[] = $item;
            }

            return [
                'success' => true,
                'message' => 'Recent activity fetched successfully.',
                'data' => $formattedData,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (RecentPatientActivity::getDoctorRecentActivity): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch recent activity: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Helper to convert datetime to relative time string (e.g., "5 mins ago")
     */
    private static function getTimeDiff($timestamp)
    {
        $datetime1 = new \DateTime($timestamp);
        $datetime2 = new \DateTime(); // current time
        $interval = $datetime1->diff($datetime2);

        if ($interval->y > 0)
            return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
        if ($interval->m > 0)
            return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
        if ($interval->d > 0)
            return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
        if ($interval->h > 0)
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
        if ($interval->i > 0)
            return $interval->i . ' min' . ($interval->i > 1 ? 's' : '') . ' ago';
        return 'Just now';
    }
}
