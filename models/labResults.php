<?php

namespace MindTrack\Models;

use PDO;
use PDOException;

class LabResults
{
    /**
     * Get PDO connection
     */
    private static function conn()
    {
        global $conn;
        return $conn;
    }

    /**
     * Get all lab results
     */
    public static function all()
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    lr.*,
                    CONCAT(p.first_name, " ", p.last_name) as patient_name,
                    p.email as patient_email,
                    pa.patient_custom_id,
                    CONCAT(d.first_name, " ", d.last_name) as doctor_name,
                    d.email as doctor_email,
                    da.specialization
                FROM lab_results lr
                LEFT JOIN users p ON lr.patient_uuid = p.uuid
                LEFT JOIN users_patient_adds pa ON p.uuid = pa.user_uuid
                LEFT JOIN users d ON lr.doctor_uuid = d.uuid
                LEFT JOIN users_doctor_adds da ON d.uuid = da.user_uuid
                ORDER BY lr.test_date DESC, lr.created_at DESC
            ');
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Lab results fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch lab results: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get all lab results for a specific patient
     */
    public static function allWherePatient($patient_uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    lr.*,
                    CONCAT(d.first_name, " ", d.last_name) as doctor_name,
                    d.email as doctor_email,
                    d.phone as doctor_phone,
                    da.specialization,
                    a.booking_code,
                    a.appointment_date
                FROM lab_results lr
                LEFT JOIN users d ON lr.doctor_uuid = d.uuid
                LEFT JOIN users_doctor_adds da ON d.uuid = da.user_uuid
                LEFT JOIN appointment a ON lr.appointment_uuid = a.uuid
                WHERE lr.patient_uuid = ?
                ORDER BY lr.test_date DESC, lr.created_at DESC
            ');
            $stmt->execute([$patient_uuid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Patient lab results fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch patient lab results: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get all lab results for a specific doctor
     */
    public static function allWhereDoctor($doctor_uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    lr.*,
                    CONCAT(p.first_name, " ", p.last_name) as patient_name,
                    p.email as patient_email,
                    pa.patient_custom_id
                FROM lab_results lr
                LEFT JOIN users p ON lr.patient_uuid = p.uuid
                LEFT JOIN users_patient_adds pa ON p.uuid = pa.user_uuid
                WHERE lr.doctor_uuid = ?
                ORDER BY lr.test_date DESC, lr.created_at DESC
            ');
            $stmt->execute([$doctor_uuid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Doctor lab results fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch doctor lab results: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get single lab result by UUID
     */
    public static function single($uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    lr.*,
                    CONCAT(p.first_name, " ", p.last_name) as patient_name,
                    p.email as patient_email,
                    pa.patient_custom_id,
                    CONCAT(d.first_name, " ", d.last_name) as doctor_name,
                    d.email as doctor_email,
                    d.phone as doctor_phone,
                    da.specialization,
                    a.booking_code,
                    a.appointment_date
                FROM lab_results lr
                LEFT JOIN users p ON lr.patient_uuid = p.uuid
                LEFT JOIN users_patient_adds pa ON p.uuid = pa.user_uuid
                LEFT JOIN users d ON lr.doctor_uuid = d.uuid
                LEFT JOIN users_doctor_adds da ON d.uuid = da.user_uuid
                LEFT JOIN appointment a ON lr.appointment_uuid = a.uuid
                WHERE lr.uuid = ?
                LIMIT 1
            ');
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Lab result fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch lab result: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Create new lab result
     */
    public static function store($data)
    {
        try {
            $stmt = self::conn()->prepare('
                INSERT INTO lab_results (
                    uuid, patient_uuid, doctor_uuid, appointment_uuid,
                    test_name, test_type, test_date, result_status,
                    result_summary, detailed_results, findings,
                    recommendations, reference_values, attachments, notes
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');

            $result = $stmt->execute([
                $data['uuid'],
                $data['patient_uuid'],
                $data['doctor_uuid'] ?? null,
                $data['appointment_uuid'] ?? null,
                $data['test_name'],
                $data['test_type'],
                $data['test_date'],
                $data['result_status'] ?? 'pending',
                $data['result_summary'] ?? null,
                $data['detailed_results'] ?? null,
                $data['findings'] ?? null,
                $data['recommendations'] ?? null,
                $data['reference_values'] ?? null,
                $data['attachments'] ?? null,
                $data['notes'] ?? null
            ]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Lab result created successfully',
                    'data' => ['uuid' => $data['uuid']]
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create lab result'
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to create lab result: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update lab result
     */
    public static function update($data)
    {
        try {
            $stmt = self::conn()->prepare('
                UPDATE lab_results 
                SET test_name = ?,
                    test_type = ?,
                    test_date = ?,
                    result_status = ?,
                    result_summary = ?,
                    detailed_results = ?,
                    findings = ?,
                    recommendations = ?,
                    reference_values = ?,
                    notes = ?
                WHERE uuid = ?
            ');

            $result = $stmt->execute([
                $data['test_name'],
                $data['test_type'],
                $data['test_date'],
                $data['result_status'],
                $data['result_summary'] ?? null,
                $data['detailed_results'] ?? null,
                $data['findings'] ?? null,
                $data['recommendations'] ?? null,
                $data['reference_values'] ?? null,
                $data['notes'] ?? null,
                $data['uuid']
            ]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Lab result updated successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update lab result'
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to update lab result: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update lab result status
     */
    public static function updateStatus($uuid, $status)
    {
        try {
            $stmt = self::conn()->prepare('
                UPDATE lab_results 
                SET result_status = ?
                WHERE uuid = ?
            ');

            $result = $stmt->execute([$status, $uuid]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Lab result status updated successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update lab result status'
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to update lab result status: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete lab result
     */
    public static function delete($uuid)
    {
        try {
            $stmt = self::conn()->prepare('DELETE FROM lab_results WHERE uuid = ?');
            $result = $stmt->execute([$uuid]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Lab result deleted successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to delete lab result'
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to delete lab result: ' . $e->getMessage(),
            ];
        }
    }
}

