<?php

namespace Mindtrack\Server\Db;

use PDO;
use PDOException;

class Attachments
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

    public static function all($reference_uuid)
    {
        try {
            $sql = "SELECT * FROM attachments WHERE reference_uuid = :reference_uuid";
            $stmt = self::conn()->prepare($sql);
            $stmt->execute([':reference_uuid' => $reference_uuid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Attachments fetched successfully',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch attachments: ' . $e->getMessage(),
            ];
        }
    }

    public static function single($reference_uuid)
    {
        try {
            $sql = "SELECT * FROM attachments WHERE reference_uuid = :reference_uuid LIMIT 1";
            $stmt = self::conn()->prepare($sql);
            $stmt->execute([':reference_uuid' => $reference_uuid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Attachment fetched successfully',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch attachment: ' . $e->getMessage(),
            ];
        }
    }

    public static function store($data = [])
    {
        try {
            self::conn()->beginTransaction();
            $sql = "INSERT INTO attachments (
                        reference_model, 
                        reference_uuid, 
                        folder, 
                        filename
                    ) VALUES (
                        :reference_model, 
                        :reference_uuid, 
                        :folder, 
                        :filename
                    )";

            $stmt = self::conn()->prepare($sql);
            $stmt->execute([
                ':reference_model' => $data['reference_model'],
                ':reference_uuid' => $data['reference_uuid'],
                ':folder' => $data['folder'],
                ':filename' => $data['filename']
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Attachment stored successfully',
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Failed to store attachment: ' . $e->getMessage(),
            ];
        }
    }

    public static function update($reference_model, $reference_uuid, $data = [])
    {
        try {
            self::conn()->beginTransaction();
            $sql = "UPDATE attachments SET 
                        folder = :folder, 
                        filename = :filename
                    WHERE reference_model = :reference_model 
                    AND reference_uuid = :reference_uuid";

            $stmt = self::conn()->prepare($sql);
            $stmt->execute([
                ':folder' => $data['folder'],
                ':filename' => $data['filename'],
                ':reference_model' => $reference_model,
                ':reference_uuid' => $reference_uuid
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Attachment updated successfully',
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Failed to update attachment: ' . $e->getMessage(),
            ];
        }
    }

    public static function deleteWhereReference($reference_uuid, $reference_model)
    {
        try {
            self::conn()->beginTransaction();
            $sql = "DELETE FROM attachments 
                    WHERE reference_uuid = :reference_uuid 
                    AND reference_model = :reference_model";

            $stmt = self::conn()->prepare($sql);
            $stmt->execute([
                ':reference_uuid' => $reference_uuid,
                ':reference_model' => $reference_model
            ]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Attachment deleted successfully',
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Failed to delete attachment: ' . $e->getMessage(),
            ];
        }
    }

    public static function deleteWhereFolder($folder = null)
    {
        try {
            self::conn()->beginTransaction();

            $sql = "DELETE FROM attachments WHERE folder = :folder";
            $stmt = self::conn()->prepare($sql);
            $stmt->execute([':folder' => $folder]);

            self::conn()->commit();
            return [
                'success' => true,
                'message' => 'Successfully deleted attachment',
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            self::conn()->rollBack();
            return [
                'success' => false,
                'message' => 'Failed to delete attachment: ' . $e->getMessage(),
            ];
        }
    }
}