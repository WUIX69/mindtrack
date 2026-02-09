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
        try {
            $stmt = self::conn()->prepare("SELECT * FROM user_{$model}_info WHERE user_uuid = ?");
            $stmt->execute([$uuid]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
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
                    INSERT INTO user_doctor_info (user_uuid, specialization, license_number, consultation_fee) VALUES (?, ?, ?, ?)
                ");
                $stmtDoctor->execute([
                    $data['uuid'],
                    $data['specialization'] ?? 'General Psychologist',
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

}
