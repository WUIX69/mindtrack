<?php

namespace Mindtrack\Server\Db;

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

    public static function singleWhereAdmin($id)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM administrators WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Admin fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch admin: ' . $e->getMessage(),
            ];
        }
    }

    public static function singleWhereUserEmail($email = null)
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

    public static function singleWhereAdminEmail($email = null)
    {
        // Implement your admin query here, for now just return empty array
        $admin = [
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => '$2y$10$xKIlO8qhCbD5hxi466mlHupG5f8LkDakJia8T90kbwsBpS/RjNhg2' // admin
        ];

        return ($email === $admin['email']) ? $admin : [];
    }

    public static function store($data = [])
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("
                INSERT INTO users (
                    uuid, firstname, lastname, email, password
                ) VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data['uuid'],
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['password']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'User registered successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'User registration failed.',
            ];
        }
    }

    public static function storeWhereUserAdmin($data = [])
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("
                INSERT INTO users (
                    uuid, firstname, lastname, email, password, telephone, dob
                ) VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data['uuid'],
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['password'],
                $data['telephone'],
                $data['dob']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'User registered successfully on admin.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'User registration failed on admin.',
            ];
        }
    }

    public static function update($data = [])
    {
        try {

            self::conn()->beginTransaction();
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
                'message' => 'User update failed.',
            ];
        }
    }

    public static function updateWherePassword($new_password = null, $user_uuid = null)
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("
                UPDATE users SET 
                    password=?
                WHERE uuid=?
            ");

            $stmt->execute([
                $new_password,
                $user_uuid
            ]);

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
                'message' => 'Password update failed.',
            ];
        }
    }

    public static function updateWhereUserAdmin($data = [])
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("
                UPDATE users SET 
                    firstname=?, 
                    lastname=?, 
                    email=?, 
                    telephone=?, 
                    dob=?
                WHERE uuid=?
            ");

            $stmt->execute([
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['telephone'],
                $data['dob'],
                $data['uuid']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'User updated successfully on admin.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'User update failed on admin.',
            ];
        }
    }

    public static function delete($user_uuid = null)
    {
        try {
            self::conn()->beginTransaction();
            $stmt = self::conn()->prepare("DELETE FROM users WHERE uuid=?");
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
                'message' => 'User deletion failed.',
            ];
        }
    }

}