<?php
/**
 * appointments Model
 * Handles database operations for the appointments table.
 */

namespace Mindtrack\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class appointments extends Base
{
    /**
     * Fetch all appointments for a specific patient.
     * 
     * @param string $patient_uuid
     * @return array
     */
    public static function allWherePatient($patient_uuid)
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT 
                    a.*, 
                    s.name as service_name, 
                    s.duration as service_duration,
                    u.firstname as doctor_firstname, 
                    u.lastname as doctor_lastname
                FROM appointments a
                JOIN services s ON a.service_uuid = s.uuid
                JOIN users u ON a.doctor_uuid = u.uuid
                WHERE a.patient_uuid = ?
                ORDER BY a.sched_date DESC, a.sched_time DESC
            ");
            $stmt->execute([$patient_uuid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Appointments fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (appointments::allWherePatient): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch appointments: ' . $e->getMessage(),
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
            error_log("SQL Error (appointments::store): " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Booking failed: ' . $e->getMessage(),
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
                'message' => 'Appointment status updated.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (appointments::updateStatus): " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Status update failed: ' . $e->getMessage(),
            ];
        }
    }
}
