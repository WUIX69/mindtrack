<?php

namespace MindTrack\Models;

use PDO;
use PDOException;

class BookingRequests
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
     * Get all booking requests
     */
    public static function all()
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    br.*,
                    CONCAT(u.first_name, " ", u.last_name) as user_name,
                    u.email as user_email,
                    u.phone as user_phone
                FROM booking_request br
                LEFT JOIN users u ON br.user_uuid = u.uuid
                ORDER BY br.created_at DESC
            ');
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Booking requests fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch booking requests: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get all booking requests for a specific user
     */
    public static function allWhereUser($user_uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    br.*
                FROM booking_request br
                WHERE br.user_uuid = ?
                ORDER BY br.created_at DESC
            ');
            $stmt->execute([$user_uuid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'User booking requests fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch user booking requests: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get all booking requests by status
     */
    public static function allWhereStatus($status)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    br.*,
                    CONCAT(u.first_name, " ", u.last_name) as user_name,
                    u.email as user_email,
                    u.phone as user_phone
                FROM booking_request br
                LEFT JOIN users u ON br.user_uuid = u.uuid
                WHERE br.status = ?
                ORDER BY br.created_at DESC
            ');
            $stmt->execute([$status]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Booking requests fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch booking requests: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get single booking request by UUID
     */
    public static function single($uuid)
    {
        try {
            $stmt = self::conn()->prepare('
                SELECT 
                    br.*,
                    CONCAT(u.first_name, " ", u.last_name) as user_name,
                    u.email as user_email,
                    u.phone as user_phone
                FROM booking_request br
                LEFT JOIN users u ON br.user_uuid = u.uuid
                WHERE br.uuid = ?
                LIMIT 1
            ');
            $stmt->execute([$uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

            return [
                'success' => true,
                'message' => 'Booking request fetched successfully',
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch booking request: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Create new booking request
     */
    public static function store($data)
    {
        try {
            $stmt = self::conn()->prepare('
                INSERT INTO booking_request (
                    uuid, user_uuid, patient_custom_id, first_name, last_name, 
                    email, service_type, birthdate, booking_date, booking_time, 
                    status, booking_code, notes
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');

            $result = $stmt->execute([
                $data['uuid'],
                $data['user_uuid'] ?? null,
                $data['patient_custom_id'] ?? null,
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['service_type'],
                $data['birthdate'],
                $data['booking_date'],
                $data['booking_time'],
                $data['status'] ?? 'pending',
                $data['booking_code'],
                $data['notes'] ?? null
            ]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Booking request created successfully',
                    'data' => ['uuid' => $data['uuid']]
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create booking request'
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to create booking request: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update booking request status
     */
    public static function updateStatus($uuid, $status)
    {
        try {
            $stmt = self::conn()->prepare('
                UPDATE booking_request 
                SET status = ?
                WHERE uuid = ?
            ');

            $result = $stmt->execute([$status, $uuid]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Booking request status updated successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update booking request status'
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to update booking request status: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete booking request
     */
    public static function delete($uuid)
    {
        try {
            $stmt = self::conn()->prepare('DELETE FROM booking_request WHERE uuid = ?');
            $result = $stmt->execute([$uuid]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Booking request deleted successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to delete booking request'
            ];
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to delete booking request: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Generate unique booking code
     */
    public static function generateBookingCode()
    {
        $prefix = 'BK';
        $timestamp = time();
        $random = rand(100, 999);
        return $prefix . $timestamp . $random;
    }
}

