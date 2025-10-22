<?php

namespace MindTrack\Models;

use PDO;
use PDOException;

class Appointments
{
    private static $conn;

    private static function conn()
    {
        if (!isset(self::$conn)) {
            global $conn;
            self::$conn = $conn;
        }
        return self::$conn;
    }

    /**
     * Get all appointments
     */
    public static function all()
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    a.*,
                    CONCAT(p.first_name, " ", p.last_name) as patient_name,
                    p.email as patient_email,
                    pa.patient_custom_id,
                    CONCAT(d.first_name, " ", d.last_name) as doctor_name,
                    d.email as doctor_email,
                    da.doctor_custom_id,
                    da.specialization
                FROM appointment a
                LEFT JOIN users p ON a.patient_uuid = p.uuid
                LEFT JOIN users_patient_adds pa ON p.uuid = pa.user_uuid
                LEFT JOIN users d ON a.doctor_uuid = d.uuid
                LEFT JOIN users_doctor_adds da ON d.uuid = da.user_uuid
                ORDER BY a.appointment_date DESC, a.appointment_time DESC
            ');
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Appointments fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch appointments: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get appointments by doctor UUID
     */
    public static function allWhereDoctor($doctor_uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    a.*,
                    CONCAT(p.first_name, " ", p.last_name) as patient_name,
                    p.email as patient_email,
                    pa.patient_custom_id,
                    CONCAT(d.first_name, " ", d.last_name) as doctor_name,
                    d.email as doctor_email,
                    da.doctor_custom_id,
                    da.specialization
                FROM appointment a
                LEFT JOIN users p ON a.patient_uuid = p.uuid
                LEFT JOIN users_patient_adds pa ON p.uuid = pa.user_uuid
                LEFT JOIN users d ON a.doctor_uuid = d.uuid
                LEFT JOIN users_doctor_adds da ON d.uuid = da.user_uuid
                WHERE a.doctor_uuid = ?
                ORDER BY a.appointment_date DESC, a.appointment_time DESC
            ');
            $stmt->execute([$doctor_uuid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Doctor appointments fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch doctor appointments: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get appointments by patient UUID
     */
    public static function allWherePatient($patient_uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    a.*,
                    CONCAT(p.first_name, " ", p.last_name) as patient_name,
                    p.email as patient_email,
                    pa.patient_custom_id,
                    CONCAT(d.first_name, " ", d.last_name) as doctor_name,
                    d.email as doctor_email,
                    da.doctor_custom_id,
                    da.specialization
                FROM appointment a
                LEFT JOIN users p ON a.patient_uuid = p.uuid
                LEFT JOIN users_patient_adds pa ON p.uuid = pa.user_uuid
                LEFT JOIN users d ON a.doctor_uuid = d.uuid
                LEFT JOIN users_doctor_adds da ON d.uuid = da.user_uuid
                WHERE a.patient_uuid = ?
                ORDER BY a.appointment_date DESC, a.appointment_time DESC
            ');
            $stmt->execute([$patient_uuid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Patient appointments fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch patient appointments: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get single appointment by UUID
     */
    public static function single($uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    a.*,
                    CONCAT(p.first_name, " ", p.last_name) as patient_name,
                    p.email as patient_email,
                    p.phone as patient_phone,
                    pa.patient_custom_id,
                    pa.birthdate,
                    pa.emergency_contact,
                    CONCAT(d.first_name, " ", d.last_name) as doctor_name,
                    d.email as doctor_email,
                    d.phone as doctor_phone,
                    da.doctor_custom_id,
                    da.specialization,
                    da.license_number
                FROM appointment a
                LEFT JOIN users p ON a.patient_uuid = p.uuid
                LEFT JOIN users_patient_adds pa ON p.uuid = pa.user_uuid
                LEFT JOIN users d ON a.doctor_uuid = d.uuid
                LEFT JOIN users_doctor_adds da ON d.uuid = da.user_uuid
                WHERE a.uuid = ?
                LIMIT 1
            ');
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Appointment fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch appointment: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Create new appointment
     */
    public static function store($data)
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                INSERT INTO appointment (
                    uuid, booking_uuid, patient_uuid, doctor_uuid, 
                    appointment_date, appointment_time, service_type, 
                    status, booking_code, remarks
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data['uuid'],
                $data['booking_uuid'] ?? null,
                $data['patient_uuid'],
                $data['doctor_uuid'] ?? null,
                $data['appointment_date'],
                $data['appointment_time'],
                $data['service_type'],
                $data['status'] ?? 'scheduled',
                $data['booking_code'],
                $data['remarks'] ?? null
            ]);

            self::conn()->commit();

            return [
                'success' => true,
                'message' => 'Appointment created successfully.',
                'data' => ['uuid' => $data['uuid']]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Appointment creation failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update appointment
     */
    public static function update($data)
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("
                UPDATE appointment SET
                    patient_uuid = ?,
                    doctor_uuid = ?,
                    appointment_date = ?,
                    appointment_time = ?,
                    service_type = ?,
                    status = ?,
                    remarks = ?,
                    prescription = ?,
                    diagnosis = ?
                WHERE uuid = ?
            ");

            $stmt->execute([
                $data['patient_uuid'],
                $data['doctor_uuid'] ?? null,
                $data['appointment_date'],
                $data['appointment_time'],
                $data['service_type'],
                $data['status'] ?? 'scheduled',
                $data['remarks'] ?? null,
                $data['prescription'] ?? null,
                $data['diagnosis'] ?? null,
                $data['uuid']
            ]);

            self::conn()->commit();

            return [
                'success' => true,
                'message' => 'Appointment updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Appointment update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update appointment status
     */
    public static function updateStatus($uuid, $status)
    {
        try {
            $stmt = self::conn()->prepare("
                UPDATE appointment SET status = ? WHERE uuid = ?
            ");
            $stmt->execute([$status, $uuid]);

            return [
                'success' => true,
                'message' => 'Appointment status updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Status update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Add prescription and diagnosis to appointment
     */
    public static function addMedicalNotes($uuid, $prescription, $diagnosis)
    {
        try {
            $stmt = self::conn()->prepare("
                UPDATE appointment SET 
                    prescription = ?,
                    diagnosis = ?
                WHERE uuid = ?
            ");
            $stmt->execute([$prescription, $diagnosis, $uuid]);

            return [
                'success' => true,
                'message' => 'Medical notes added successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to add medical notes: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete appointment
     */
    public static function delete($uuid)
    {
        try {
            self::conn()->beginTransaction();

            $stmt = self::conn()->prepare("DELETE FROM appointment WHERE uuid = ?");
            $stmt->execute([$uuid]);

            self::conn()->commit();

            return [
                'success' => true,
                'message' => 'Appointment deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Appointment deletion failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Generate unique booking code
     */
    public static function generateBookingCode()
    {
        return 'APT' . date('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6));
    }
}

