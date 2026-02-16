<?php

namespace Mindtrack\Features\Patients\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Patients extends Base
{
    /**
     * Get all patients for DataTable (or other lists)
     * This might be redundant if using DataTables class directly with raw query, 
     * but good for abstraction. 
     */
    public static function all()
    {
        // ... (Usually handled by DataTables lib for admin view)
    }

    /**
     * Get a single patient's full details
     */
    public static function single($uuid)
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT 
                    u.uuid,
                    u.firstname,
                    u.lastname,
                    u.email,
                    u.phone,
                    u.status,
                    u.created_at,
                    pi.date_of_birth,
                    pi.gender,
                    pi.address,
                    pi.emergency_contact_name,
                    pi.emergency_contact_phone,
                    pi.medical_history
                FROM users u
                LEFT JOIN user_patient_info pi ON u.uuid = pi.user_uuid
                WHERE u.uuid = ? AND u.role = 'patient'
            ");
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                // Decode JSON fields if they are strings
                if (isset($data['medical_history']) && is_string($data['medical_history'])) {
                    $data['medical_history'] = json_decode($data['medical_history'], true) ?? [];
                }

                return [
                    'success' => true,
                    'data' => $data
                ];
            }

            return ['success' => false, 'message' => 'Patient not found'];
        } catch (PDOException $e) {
            error_log("Patients::single Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error'];
        }
    }

    /**
     * Create a new patient
     */
    public static function store($data)
    {
        try {
            self::beginTransaction();

            // 1. Insert into users
            $stmt = self::conn()->prepare("
                INSERT INTO users (uuid, firstname, lastname, email, password, phone, role, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, 'patient', ?, NOW())
            ");

            // Generate UUID if not provided (though typically passed from action)
            $uuid = $data['uuid'] ?? uuid();
            // Default password for manually added patients? Or random?
            // Let's assume action handles hashing. If manually added, maybe a default or generated one.
            // For this scope, assume 'password' key exists in data (hashed).

            $stmt->execute([
                $uuid,
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['password'], // Hash this in the action before passing!
                $data['phone'],
                $data['status'] ?? 'active'
            ]);

            // 2. Insert into user_patient_info
            $stmtInfo = self::conn()->prepare("
                INSERT INTO user_patient_info (
                    user_uuid, 
                    date_of_birth, 
                    gender, 
                    address, 
                    emergency_contact_name, 
                    emergency_contact_phone, 
                    medical_history
                ) VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $medicalHistory = json_encode($data['medical_history'] ?? []);

            $stmtInfo->execute([
                $uuid,
                $data['date_of_birth'] ?? null,
                $data['gender'] ?? null,
                $data['address'] ?? null,
                $data['emergency_contact_name'] ?? null,
                $data['emergency_contact_phone'] ?? null,
                $medicalHistory
            ]);

            self::commit();
            return ['success' => true, 'message' => 'Patient created successfully', 'uuid' => $uuid];

        } catch (PDOException $e) {
            self::rollBack();
            error_log("Patients::store Error: " . $e->getMessage());
            // Check for duplicate email
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
            return ['success' => false, 'message' => 'Failed to create patient'];
        }
    }

    /**
     * Update an existing patient
     */
    public static function update($data)
    {
        try {
            self::beginTransaction();

            // 1. Update users table
            $query = "UPDATE users SET firstname=?, lastname=?, email=?, phone=?, status=? WHERE uuid=?";
            $params = [
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['phone'],
                $data['status'] ?? 'active',
                $data['uuid']
            ];

            // If password update is needed, it should probably be a separate call or check if set
            // For now, let's keep it simple (profile updates usually don't force password change unless specified)

            $stmt = self::conn()->prepare($query);
            $stmt->execute($params);

            // 2. Upsert user_patient_info
            $stmtInfo = self::conn()->prepare("
                INSERT INTO user_patient_info (
                    user_uuid, 
                    date_of_birth, 
                    gender, 
                    address, 
                    emergency_contact_name, 
                    emergency_contact_phone, 
                    medical_history
                ) VALUES (?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    date_of_birth = VALUES(date_of_birth),
                    gender = VALUES(gender),
                    address = VALUES(address),
                    emergency_contact_name = VALUES(emergency_contact_name),
                    emergency_contact_phone = VALUES(emergency_contact_phone),
                    medical_history = VALUES(medical_history)
            ");

            $medicalHistory = json_encode($data['medical_history'] ?? []);

            $stmtInfo->execute([
                $data['uuid'],
                $data['date_of_birth'] ?? null,
                $data['gender'] ?? null,
                $data['address'] ?? null,
                $data['emergency_contact_name'] ?? null,
                $data['emergency_contact_phone'] ?? null,
                $medicalHistory
            ]);

            self::commit();
            return ['success' => true, 'message' => 'Patient updated successfully'];

        } catch (PDOException $e) {
            self::rollBack();
            error_log("Patients::update Error: " . $e->getMessage());
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
            return ['success' => false, 'message' => 'Failed to update patient'];
        }
    }

    /**
     * Delete a patient
     */
    public static function delete($uuid)
    {
        try {
            // Foreign keys should cascade, so deleting from users is enough
            $stmt = self::conn()->prepare("DELETE FROM users WHERE uuid = ?");
            $stmt->execute([$uuid]);

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Patient deleted successfully'];
            }

            return ['success' => false, 'message' => 'Patient not found or already deleted'];

        } catch (PDOException $e) {
            error_log("Patients::delete Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete patient'];
        }
    }
}
