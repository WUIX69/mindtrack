<?php

namespace Mindtrack\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Users extends Base
{
    public static function all()
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM users');
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Users fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch users: ' . $e->getMessage(),
            ];
        }
    }

    public static function allWhereDoctors()
    {
        try {
            $stmt = self::conn()->prepare("
            SELECT u.uuid, u.firstname, u.lastname, u.email, u.phone, u.status, s.name AS specialization, di.availability 
            FROM users u 
            JOIN user_doctor_info di ON u.uuid = di.user_uuid 
            LEFT JOIN specializations s ON di.specialization_id = s.id
            WHERE u.role = 'doctor'
        ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Doctors fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch doctors',
            ];
        }
    }

    public static function allWhereDoctorsSpecialization($specializationId = null)
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT u.uuid, u.firstname, u.lastname, u.email, u.phone, u.status, s.name AS specialization, di.availability 
                FROM users u 
                JOIN user_doctor_info di ON u.uuid = di.user_uuid 
                LEFT JOIN specializations s ON di.specialization_id = s.id
                WHERE u.role = 'doctor' 
                AND di.specialization_id = ?
            ");
            $stmt->execute([$specializationId]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Doctors fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch doctors by specialization',
            ];
        }
    }

    public static function allWherePatients()
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT u.uuid as id, CONCAT(u.firstname, ' ', u.lastname) as name, u.email 
                FROM users u 
                WHERE u.role = 'patient' AND u.status = 'active'
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Patients fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Users::allWherePatients): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch patients',
            ];
        }
    }


    public static function single($uuid = null)
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM users WHERE uuid=? LIMIT 1');
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'User fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch user: ' . $e->getMessage(),
            ];
        }
    }

    public static function singleWhereEmail($email = null)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    public static function singleWhereOtherData($uuid, $model)
    {
        if ($model === 'admin') {
            return [];
        }
        try {
            $query = "SELECT * FROM user_{$model}_info WHERE user_uuid = ?";
            if ($model === 'doctor') {
                $query = "
                    SELECT di.*, s.name AS specialization 
                    FROM user_doctor_info di 
                    LEFT JOIN specializations s ON di.specialization_id = s.id 
                    WHERE di.user_uuid = ?
                ";
            }
            $stmt = self::conn()->prepare($query);
            $stmt->execute([$uuid]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    public static function singleWherePatient($uuid)
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT u.uuid as id, CONCAT(u.firstname, ' ', u.lastname) as name, u.email 
                FROM users u 
                WHERE u.role = 'patient' AND u.status = 'active' AND u.uuid = ?
            ");
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

            if (!$data) {
                return [
                    'success' => false,
                    'message' => 'Patient not found',
                ];
            }

            return [
                'success' => true,
                'message' => 'Patient fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Users::singleWherePatient): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch patient',
            ];
        }
    }

    public static function store($data = [])
    {
        try {
            self::beginTransaction();

            // 1. Insert into users table
            $stmt = self::conn()->prepare("
                INSERT INTO users (
                    uuid, firstname, lastname, email, password, phone, role, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $role = $data['role'] ?? 'patient';
            $status = 'active'; // Default status

            $stmt->execute([
                $data['uuid'],
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['password'], // Password should already be hashed
                $data['phone'],
                $role,
                $status,
            ]);

            // 2. Insert into role-specific table
            if ($role === 'patient') {
                $stmtPatient = self::conn()->prepare("
                    INSERT INTO user_patient_info (user_uuid) VALUES (?)
                ");
                $stmtPatient->execute([$data['uuid']]);
            } elseif ($role === 'doctor') {
                $stmtDoctor = self::conn()->prepare("
                    INSERT INTO user_doctor_info (user_uuid, specialization_id, license_number, consultation_fee) VALUES (?, ?, ?, ?)
                ");

                // Keep defaults safe, assuming 'General Psychologist' is 8 or similar. 
                // Creating a fallback logic if ID not known is complex without looking it up, 
                // so we rely on the migration logic ensuring IDs exist.
                $specId = $data['specialization_id'] ?? 8;

                $stmtDoctor->execute([
                    $data['uuid'],
                    $specId,
                    $data['license_number'] ?? 'LIC-' . strtoupper(bin2hex(random_bytes(4))),
                    $data['consultation_fee'] ?? 1000.00
                ]);
            }

            self::commit();
            return [
                'success' => true,
                'message' => 'User registered successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'User registration failed.',
            ];
        }
    }

    public static function update($data = [])
    {
        try {

            self::beginTransaction();
            $stmt = self::conn()->prepare("
                UPDATE users SET 
                    firstname=?, 
                    lastname=?, 
                    email=?, 
                    bio=?, 
                    telephone=?, 
                    dob=?, 
                    location=?,
                    urls=?
                WHERE uuid=?
            ");

            $stmt->execute([
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['bio'],
                $data['telephone'],
                $data['dob'],
                $data['location'],
                $data['urls'],
                $data['user_uuid']
            ]);

            self::commit();
            return [
                'success' => true,
                'message' => 'User updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'User update failed.',
            ];
        }
    }

    public static function updateWherePassword($new_password = null, $user_uuid = null)
    {
        try {
            self::beginTransaction();
            $stmt = self::conn()->prepare("
                UPDATE users SET 
                    password=?
                WHERE uuid=?
            ");

            $stmt->execute([
                $new_password,
                $user_uuid
            ]);

            self::commit();
            return [
                'success' => true,
                'message' => 'Password updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'Password update failed.',
            ];
        }
    }

    public static function delete($user_uuid = null)
    {
        try {
            self::beginTransaction();
            $stmt = self::conn()->prepare("DELETE FROM users WHERE uuid=?");
            $stmt->execute([$user_uuid]);
            self::commit();
            return [
                'success' => true,
                'message' => 'User deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::rollBack();
            return [
                'success' => false,
                'message' => 'User deletion failed.',
            ];
        }
    }

    public static function storeWhereDoctor($data)
    {
        try {
            self::beginTransaction();

            // 1. Insert User
            $stmt = self::conn()->prepare("
                INSERT INTO users (uuid, firstname, lastname, email, password, phone, role, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, 'doctor', 'active', NOW())
            ");

            $stmt->execute([
                $data['uuid'],
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['password'],
                $data['phone']
            ]);

            // 2. Insert Doctor Info
            $stmt = self::conn()->prepare("
                INSERT INTO user_doctor_info (user_uuid, specialization_id, license_number, bio, availability)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data['uuid'],
                $data['specialization_id'],
                $data['license_number'],
                $data['bio'],
                json_encode($data['availability'])
            ]);

            self::commit();
            return ['success' => true, 'message' => 'Doctor created successfully'];

        } catch (PDOException $e) {
            self::rollBack();
            error_log("SQL Error (Users::storeWhereDoctor): " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create doctor'];
        }
    }

    public static function updateWhereDoctor($data)
    {
        try {
            self::beginTransaction();

            // 1. Update User
            $query = "UPDATE users SET firstname=?, lastname=?, email=?, phone=?";
            $params = [
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['phone']
            ];

            if (!empty($data['password'])) {
                $query .= ", password=?";
                $params[] = $data['password'];
            }

            $query .= " WHERE uuid=?";
            $params[] = $data['uuid'];

            $stmt = self::conn()->prepare($query);
            $stmt->execute($params);

            // 2. Update Doctor Info (Upsert)
            $stmt = self::conn()->prepare("
                INSERT INTO user_doctor_info (user_uuid, specialization_id, license_number, bio, availability)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    specialization_id = VALUES(specialization_id),
                    license_number = VALUES(license_number),
                    bio = VALUES(bio),
                    availability = VALUES(availability)
            ");

            $stmt->execute([
                $data['uuid'],
                $data['specialization_id'],
                $data['license_number'],
                $data['bio'],
                json_encode($data['availability'])
            ]);

            self::commit();
            return ['success' => true, 'message' => 'Doctor updated successfully'];

        } catch (PDOException $e) {
            self::rollBack();
            error_log("SQL Error (Users::updateWhereDoctor): " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update doctor'];
        }
    }

    public static function singleWhereDoctor($uuid)
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT 
                    u.uuid,
                    CONCAT(u.firstname, ' ', u.lastname) AS doctor_name,
                    u.firstname,
                    u.lastname,
                    u.email,
                    u.phone,
                    u.status,
                    s.id as specialization_id,
                    s.name AS specialty,
                    di.license_number,
                    di.bio,
                    di.availability
                FROM users u
                LEFT JOIN user_doctor_info di ON u.uuid = di.user_uuid
                LEFT JOIN specializations s ON di.specialization_id = s.id
                WHERE u.uuid = ? AND u.role = 'doctor'
            ");
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return [
                    'success' => true,
                    'message' => 'Doctor details fetched successfully.',
                    'data' => $data
                ];
            }

            return [
                'success' => false,
                'message' => 'Doctor not found.'
            ];

        } catch (PDOException $e) {
            error_log("SQL Error (Users::singleWhereDoctor): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error occurred.'
            ];
        }
    }
}