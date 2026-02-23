<?php

namespace Mindtrack\Features\Notes\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Notes extends Base
{
    /**
     * Fetch a specific clinical note by Note UUID
     * @param string $uuid
     * @return array Returns the note details inside a standardized response array
     */
    public static function single($uuid)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM clinical_notes WHERE uuid = :uuid");
            $stmt->execute(['uuid' => $uuid]);
            $note = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'message' => 'Note fetched successfully',
                'data' => $note ?: null
            ];

        } catch (PDOException $e) {
            error_log("Notes single error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error while fetching note',
                'data' => null
            ];
        }
    }

    /**
     * Fetch a specific clinical note by appointment UUID
     * @param string $appointmentUuid
     * @return array Returns the note details inside a standardized response array
     */
    public static function findByAppointment($appointmentUuid)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM clinical_notes WHERE appointment_uuid = :uuid");
            $stmt->execute(['uuid' => $appointmentUuid]);
            $note = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'message' => 'Note fetched successfully',
                'data' => $note ?: null
            ];

        } catch (PDOException $e) {
            error_log("Notes findByAppointment error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error while fetching note',
                'data' => null
            ];
        }
    }

    /**
     * Fetch all notes for a specific doctor
     * @param string $doctorUuid
     * @return array Returns array of notes inside a standardized response array
     */
    public static function allWhereDoctor($doctorUuid)
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT 
                    cn.uuid,
                    cn.appointment_uuid,
                    cn.patient_uuid,
                    cn.status,
                    cn.updated_at,
                    p.firstname as patient_firstname,
                    p.lastname as patient_lastname,
                    a.sched_date,
                    a.sched_time,
                    s.name as service_name
                FROM clinical_notes cn
                JOIN appointments a ON cn.appointment_uuid = a.uuid
                JOIN users p ON cn.patient_uuid = p.uuid
                JOIN services s ON a.service_uuid = s.uuid
                WHERE cn.doctor_uuid = :doctor_uuid
                ORDER BY cn.updated_at DESC
            ");
            $stmt->execute(['doctor_uuid' => $doctorUuid]);
            $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'message' => 'Notes list fetched successfully',
                'data' => $notes
            ];

        } catch (PDOException $e) {
            error_log("Notes allWhereDoctor error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error while fetching notes list',
                'data' => []
            ];
        }
    }

    /**
     * Create a new clinical note
     * @param array $data Asssociative array containing the note data
     * @return array success status and optionally the generated UUID
     */
    public static function store($data = [])
    {
        try {
            $stmt = self::conn()->prepare("
                INSERT INTO clinical_notes (
                    uuid, 
                    appointment_uuid, 
                    patient_uuid, 
                    doctor_uuid, 
                    subjective, 
                    objective, 
                    assessment, 
                    plan, 
                    status
                ) VALUES (
                    :uuid, 
                    :appointment_uuid, 
                    :patient_uuid, 
                    :doctor_uuid, 
                    :subjective, 
                    :objective, 
                    :assessment, 
                    :plan, 
                    :status
                )
            ");

            $stmt->execute([
                'uuid' => $data['uuid'],
                'appointment_uuid' => $data['appointment_uuid'],
                'patient_uuid' => $data['patient_uuid'],
                'doctor_uuid' => $data['doctor_uuid'],
                'subjective' => $data['subjective'] ?? null,
                'objective' => $data['objective'] ?? null,
                'assessment' => $data['assessment'] ?? null,
                'plan' => $data['plan'] ?? null,
                'status' => $data['status'] ?? 'draft'
            ]);

            return ['success' => true, 'message' => 'Clinical note created successfully'];
        } catch (PDOException $e) {
            error_log("Notes store error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error while saving note'];
        }
    }

    /**
     * Update an existing clinical note
     * @param string $uuid Note UUID
     * @param array $data Asssociative array containing the fields to update
     * @return array success status
     */
    public static function update($uuid, $data = [])
    {
        try {
            // First check if note is already signed
            $check = self::conn()->prepare("SELECT status FROM clinical_notes WHERE uuid = :uuid");
            $check->execute(['uuid' => $uuid]);
            $currentStatus = $check->fetchColumn();

            if ($currentStatus === 'signed') {
                return ['success' => false, 'message' => 'Cannot modify a signed note'];
            }

            $stmt = self::conn()->prepare("
                UPDATE clinical_notes SET 
                    subjective = :subjective,
                    objective = :objective,
                    assessment = :assessment,
                    plan = :plan,
                    status = :status
                WHERE uuid = :uuid
            ");

            $stmt->execute([
                'uuid' => $uuid,
                'subjective' => $data['subjective'] ?? null,
                'objective' => $data['objective'] ?? null,
                'assessment' => $data['assessment'] ?? null,
                'plan' => $data['plan'] ?? null,
                'status' => $data['status'] ?? 'draft'
            ]);

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Clinical note updated successfully'];
            }
            return ['success' => true, 'message' => 'No changes made']; // Still consider success if nothing physically changed

        } catch (PDOException $e) {
            error_log("Notes update error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error while saving note'];
        }
    }

    /**
     * Finalize and sign a clinical note
     * @param string $uuid Note UUID
     * @return array success status
     */
    public static function sign($uuid)
    {
        try {
            $stmt = self::conn()->prepare("
                UPDATE clinical_notes SET 
                    status = 'signed'
                WHERE uuid = :uuid
            ");

            $stmt->execute(['uuid' => $uuid]);

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Note signed successfully'];
            }
            return ['success' => false, 'message' => 'Note not found or already signed'];

        } catch (PDOException $e) {
            error_log("Notes sign error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error while signing note'];
        }
    }
}
