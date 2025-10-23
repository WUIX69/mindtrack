<?php

namespace MindTrack\Models;

use PDO;
use PDOException;

class Users
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
     * Get all users
     * 
     * @return array
     */
    public static function all()
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM users ORDER BY created_at DESC');
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

    /**
     * Get single user by UUID
     * 
     * @param string $uuid UUID
     * @return array
     */
    public static function single($uuid = null)
    {
        try {
            $stmt = self::conn()->prepare('SELECT * FROM users WHERE uuid = ? LIMIT 1');
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

    /**
     * Get user by email
     * 
     * @param string $email
     * @return array User data or empty array
     */
    public static function singleWhereEmail($email = null)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get user by username
     * 
     * @param string $username
     * @return array User data or empty array
     */
    public static function singleWhereUsername($username = null)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get user by role
     * 
     * @param string $role admin|doctor|patient
     * @return array
     */
    public static function allWhereRole($role = null)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM users WHERE role = ? ORDER BY created_at DESC");
            $stmt->execute([$role]);
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

    /**
     * Create new user
     * 
     * @param array $data User data
     * @return array
     */
    public static function store($data = [])
    {
        try {
            self::conn()->beginTransaction();

            // Generate UUID if not provided
            $uuid = $data['uuid'] ?? generateUUID();

            // Insert into main users table
            $stmt = self::conn()->prepare("
                INSERT INTO users (
                    uuid, email, username, password, first_name, last_name, 
                    role, status, phone, avatar
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $uuid,
                $data['email'],
                $data['username'],
                $data['password'], // Should be hashed before passing
                $data['first_name'],
                $data['last_name'],
                $data['role'] ?? 'patient',
                $data['status'] ?? 'active',
                $data['phone'] ?? null,
                $data['avatar'] ?? null
            ]);

            // Insert into role-specific extension table
            $role = $data['role'] ?? 'patient';

            if ($role === 'doctor') {
                // Insert into users_doctor_adds with minimal data
                $stmt = self::conn()->prepare("
                    INSERT INTO users_doctor_adds (
                        uuid, user_uuid, doctor_custom_id, specialization, license_number
                    ) VALUES (?, ?, ?, ?, ?)
                ");

                // Generate doctor custom ID if not provided
                $doctor_custom_id = $data['doctor_custom_id'] ?? self::generateDoctorId();

                $stmt->execute([
                    generateUUID(), // UUID for the extension table record
                    $uuid, // Link to the user's UUID
                    $doctor_custom_id,
                    null, // specialization - will be added later in profile
                    null  // license_number - will be added later in profile
                ]);
            } elseif ($role === 'patient') {
                // Insert into users_patient_adds with minimal data
                $stmt = self::conn()->prepare("
                    INSERT INTO users_patient_adds (
                        uuid, user_uuid, patient_custom_id, birthdate, 
                        emergency_contact, service_type, doctor_uuid, diagnosis
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");

                // Generate patient custom ID if not provided
                $patient_custom_id = $data['patient_custom_id'] ?? self::generatePatientId();

                $stmt->execute([
                    generateUUID(), // UUID for the extension table record
                    $uuid, // Link to the user's UUID
                    $patient_custom_id,
                    null, // birthdate - will be added later in profile
                    null, // emergency_contact - will be added later in profile
                    null, // service_type - will be added later in profile
                    null, // doctor_uuid - will be assigned later
                    null  // diagnosis - will be added later
                ]);
            }
            // Note: Admin role doesn't need an extension table

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'User registered successfully.',
                'data' => ['uuid' => $uuid]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            error_log("SQL Error Code: " . $e->getCode());
            error_log("User Data: " . json_encode($data));
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'User registration failed: ' . $e->getMessage(),
                'debug' => $e->getMessage() // Remove this in production
            ];
        }
    }

    /**
     * Update user information
     * 
     * @param array $data User data with 'uuid' field
     * @return array
     */
    public static function update($data = [])
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("
                UPDATE users SET 
                    first_name = ?, 
                    last_name = ?, 
                    email = ?, 
                    username = ?,
                    phone = ?,
                    avatar = ?,
                    status = ?
                WHERE uuid = ?
            ");

            $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['username'],
                $data['phone'] ?? null,
                $data['avatar'] ?? null,
                $data['status'] ?? 'active',
                $data['uuid']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'User updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'User update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update user password
     * 
     * @param string $new_password Hashed password
     * @param string $user_uuid UUID
     * @return array
     */
    public static function updatePassword($new_password = null, $user_uuid = null)
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("UPDATE users SET password = ? WHERE uuid = ?");
            $stmt->execute([$new_password, $user_uuid]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Password updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Password update failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update last login timestamp
     * 
     * @param string $user_uuid UUID
     * @return bool
     */
    public static function updateLastLogin($user_uuid = null)
    {
        try {
            $stmt = self::conn()->prepare("UPDATE users SET last_login = NOW() WHERE uuid = ?");
            $stmt->execute([$user_uuid]);
            return true;
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete user
     * 
     * @param string $user_uuid UUID
     * @return array
     */
    public static function delete($user_uuid = null)
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("DELETE FROM users WHERE uuid = ?");
            $stmt->execute([$user_uuid]);
            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'User deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'User deletion failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check if email exists
     * 
     * @param string $email
     * @param string $exclude_uuid UUID to exclude from check (for updates)
     * @return bool
     */
    public static function emailExists($email, $exclude_uuid = null)
    {
        try {
            if ($exclude_uuid) {
                $stmt = self::conn()->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND uuid != ?");
                $stmt->execute([$email, $exclude_uuid]);
            } else {
                $stmt = self::conn()->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                $stmt->execute([$email]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if username exists
     * 
     * @param string $username
     * @param string $exclude_uuid UUID to exclude from check (for updates)
     * @return bool
     */
    public static function usernameExists($username, $exclude_uuid = null)
    {
        try {
            if ($exclude_uuid) {
                $stmt = self::conn()->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND uuid != ?");
                $stmt->execute([$username, $exclude_uuid]);
            } else {
                $stmt = self::conn()->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
                $stmt->execute([$username]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify user email
     * 
     * @param string $user_uuid UUID
     * @return array
     */
    public static function verifyEmail($user_uuid = null)
    {
        try {
            $stmt = self::conn()->prepare("UPDATE users SET email_verified = 1 WHERE uuid = ?");
            $stmt->execute([$user_uuid]);
            return [
                'success' => true,
                'message' => 'Email verified successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Email verification failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Generate unique patient custom ID
     * Format: PMMDDYY or PMMDDYY-N for duplicates
     * 
     * @return string
     */
    private static function generatePatientId()
    {
        try {
            // Format: P + MMDDYY
            $date = date('mdy'); // Month, Day, Year (2 digits each)
            $base_id = 'P' . $date;

            // Check if ID exists
            $stmt = self::conn()->prepare("
                SELECT COUNT(*) FROM users_patient_adds 
                WHERE patient_custom_id LIKE ?
            ");
            $stmt->execute([$base_id . '%']);
            $count = $stmt->fetchColumn();

            // If no duplicates, return base ID
            if ($count == 0) {
                return $base_id;
            }

            // If duplicates exist, append counter
            return $base_id . '-' . ($count + 1);

        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            // Fallback to UUID-based ID
            return 'P' . substr(str_replace('-', '', generateUUID()), 0, 8);
        }
    }

    /**
     * Generate unique doctor custom ID
     * Format: DR##### (5 digits, auto-incrementing)
     * 
     * @return string
     */
    private static function generateDoctorId()
    {
        try {
            // Get the highest current doctor ID number
            $stmt = self::conn()->prepare("
                SELECT doctor_custom_id FROM users_doctor_adds 
                WHERE doctor_custom_id LIKE 'DR%'
                ORDER BY doctor_custom_id DESC 
                LIMIT 1
            ");
            $stmt->execute();
            $last_id = $stmt->fetchColumn();

            if ($last_id) {
                // Extract number from DR##### format
                $number = intval(substr($last_id, 2));
                $new_number = $number + 1;
            } else {
                // Start from 1 if no doctors exist
                $new_number = 1;
            }

            // Format as DR##### with leading zeros
            return 'DR' . str_pad($new_number, 5, '0', STR_PAD_LEFT);

        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            // Fallback to random number
            return 'DR' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }
    }

    /**
     * Get patient-specific data from users_patient_adds
     */
    public static function getPatientAdds($user_uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT * FROM users_patient_adds 
                WHERE user_uuid = ? 
                LIMIT 1
            ');
            $stmt->execute([$user_uuid]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get doctor-specific data from users_doctor_adds
     */
    public static function getDoctorAdds($user_uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT * FROM users_doctor_adds 
                WHERE user_uuid = ? 
                LIMIT 1
            ');
            $stmt->execute([$user_uuid]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
        }
    }
}
