<?php

/**
 * Schedules Model
 * Handles database operations for the doctor's schedule (appointments).
 * Extends Base to use the shared database connection.
 */

namespace Mindtrack\Features\Schedule\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Schedules extends Base
{
    /**
     * Fetch appointments for a specific doctor within a date range.
     * Joins with patients and services to get full details.
     * 
     * @param string $doctorUuid
     * @param string $startDate (Y-m-d)
     * @param string $endDate (Y-m-d)
     * @return array
     */
    public static function getRange($doctorUuid, $startDate, $endDate)
    {
        try {
            // Using Base::conn() to get the connection
            $stmt = self::conn()->prepare("
                SELECT 
                    a.*, 
                    s.name as service_name, 
                    s.duration as service_duration,
                    u.firstname as patient_firstname, 
                    u.lastname as patient_lastname,
                    u.email as patient_email,
                    d.firstname as doctor_firstname,
                    d.lastname as doctor_lastname
                FROM appointments a
                LEFT JOIN services s ON a.service_uuid = s.uuid
                LEFT JOIN users u ON a.patient_uuid = u.uuid
                LEFT JOIN users d ON a.doctor_uuid = d.uuid
                WHERE a.doctor_uuid = ? 
                AND a.sched_date BETWEEN ? AND ?
                ORDER BY a.sched_date ASC, a.sched_time ASC
            ");
            $stmt->execute([$doctorUuid, $startDate, $endDate]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Schedule fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Schedules::getRange): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch schedule: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Store a new appointment.
     * 
     * @param array $data
     * @return array
     */
    public static function store($data = [])
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO appointments (
                    uuid, 
                    patient_uuid, 
                    doctor_uuid, 
                    service_uuid, 
                    sched_date, 
                    sched_time, 
                    status, 
                    notes
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?
                )
            ");

            $stmt->execute([
                $data['uuid'],
                $data['patient_uuid'],
                $data['doctor_uuid'],
                $data['service_uuid'],
                $data['sched_date'],
                $data['sched_time'],
                $data['status'] ?? 'pending',
                $data['notes'] ?? null
            ]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Appointment booked successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Schedules::store): " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Booking failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update an existing appointment.
     * 
     * @param string $uuid
     * @param array $data
     * @return array
     */
    public static function update($uuid, $data = [])
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE appointments SET 
                    service_uuid = ?, 
                    sched_date = ?, 
                    sched_time = ?, 
                    status = ?, 
                    notes = ?
                WHERE uuid = ? AND doctor_uuid = ?
            ");

            $stmt->execute([
                $data['service_uuid'],
                $data['sched_date'],
                $data['sched_time'],
                $data['status'],
                $data['notes'] ?? null,
                $uuid,
                $data['doctor_uuid'] // Security check: ensure doctor owns this
            ]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Appointment updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Schedules::update): " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update appointment status.
     * 
     * @param string $uuid
     * @param string $status
     * @return array
     */
    public static function updateStatus($uuid, $status)
    {
        try {
            self::beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE appointments SET status = ? WHERE uuid = ?
            ");
            $stmt->execute([$status, $uuid]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Status updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Schedules::updateStatus): " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Status update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete an appointment.
     * 
     * @param string $uuid
     * @return array
     */
    public static function delete($uuid)
    {
        try {
            $stmt = self::conn()->prepare("DELETE FROM appointments WHERE uuid = ?");
            $stmt->execute([$uuid]);
            return [
                'success' => true,
                'message' => 'Appointment deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Schedules::delete): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get appointment counts grouped by status for a specific doctor.
     * 
     * @param string $doctorUuid
     * @return array
     */
    public static function countWhereStatus($doctorUuid)
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT status, COUNT(*) as count 
                FROM appointments 
                WHERE doctor_uuid = ? 
                GROUP BY status
            ");
            $stmt->execute([$doctorUuid]);
            $rawCounts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?? [];

            // Initialize defaults
            $counts = [
                'pending' => 0,
                'confirmed' => 0, // Maps to 'Upcoming' in UI
                'completed' => 0,
                'cancelled' => 0,
                'all' => 0
            ];

            $total = 0;
            foreach ($rawCounts as $status => $count) {
                $total += $count;
                if ($status === 'scheduled' || $status === 'confirmed') {
                    $counts['confirmed'] += $count;
                } elseif (isset($counts[$status])) {
                    $counts[$status] += $count;
                }
            }
            $counts['all'] = $total;

            return $counts;
        } catch (PDOException $e) {
            error_log("SQL Error (Schedules::countWhereStatus): " . $e->getMessage());
            return [];
        }
    }
}
