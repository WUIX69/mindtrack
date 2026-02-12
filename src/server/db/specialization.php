<?php

namespace Mindtrack\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Specialization extends Base
{

    /**
     * Get all specializations.
     * 
     * @return array
     */
    public static function all()
    {
        try {
            $query = "SELECT * FROM specializations ORDER BY name ASC";
            $stmt = self::conn()->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
            return [
                'success' => true,
                'message' => 'Specializations fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::all): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Specialization fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function single($id)
    {
        try {
            $stmt = self::conn()->prepare("SELECT * FROM specializations WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            return [
                'success' => true,
                'message' => 'Specialization fetched successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::single): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Specialization fetching failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function store($data)
    {
        try {
            $stmt = self::conn()->prepare("INSERT INTO specializations (name, description) VALUES (?, ?)");
            $stmt->execute([$data['name'], $data['description']]);
            $data = self::conn()->lastInsertId();
            return [
                'success' => true,
                'message' => 'Specialization created successfully.',
                'data' => $data,
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::store): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Specialization creation failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function update($id, $data)
    {
        try {
            $stmt = self::conn()->prepare("UPDATE specializations SET name = ?, description = ? WHERE id = ?");
            $stmt->execute([$data['name'], $data['description'], $id]);
            return [
                'success' => true,
                'message' => 'Specialization updated successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::update): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Specialization update failed: ' . $e->getMessage(),
            ];
        }
    }

    public static function delete($id)
    {
        try {
            $stmt = self::conn()->prepare("DELETE FROM specializations WHERE id = ?");
            $stmt->execute([$id]);
            return [
                'success' => true,
                'message' => 'Specialization deleted successfully.',
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Specialization::delete): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Specialization deletion failed: ' . $e->getMessage(),
            ];
        }
    }

}
