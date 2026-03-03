<?php

declare(strict_types=1);

namespace Mindtrack\Features\Notes\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Stats extends Base
{
    /**
     * Get documentation compliance metrics (signed, within 24h, late).
     * 
     * @return array
     */
    public static function getDocumentationCompliance(): array
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT
                    COUNT(*) as total_notes,
                    SUM(CASE WHEN status = 'signed' THEN 1 ELSE 0 END) as signed_notes,
                    SUM(CASE WHEN status = 'signed' AND TIMESTAMPDIFF(HOUR, created_at, updated_at) <= 24 THEN 1 ELSE 0 END) as within_24h,
                    SUM(CASE WHEN status = 'signed' AND TIMESTAMPDIFF(HOUR, created_at, updated_at) > 24 THEN 1 ELSE 0 END) as late_submissions
                FROM clinical_notes
            ");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $total = (int) ($data['total_notes'] ?? 0);
            $signed = (int) ($data['signed_notes'] ?? 0);
            $within24h = (int) ($data['within_24h'] ?? 0);
            $late = (int) ($data['late_submissions'] ?? 0);

            $signedPercent = $total > 0 ? round(($signed / $total) * 100) : 0;
            $within24hPercent = $signed > 0 ? round(($within24h / $signed) * 100) : 0;
            $latePercent = $signed > 0 ? round(($late / $signed) * 100) : 0;

            return [
                'success' => true,
                'message' => 'Compliance metrics fetched successfully.',
                'data' => [
                    'signed_percent' => $signedPercent,
                    'within_24h_percent' => $within24hPercent,
                    'late_percent' => $latePercent,
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Stats::getDocumentationCompliance): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch compliance metrics.',
                'data' => [
                    'signed_percent' => 0,
                    'within_24h_percent' => 0,
                    'late_percent' => 0,
                ]
            ];
        }
    }

    /**
     * Get the 5 most recently finalized/updated notes.
     * 
     * @return array
     */
    public static function getRecentFinalizations(): array
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT 
                    n.uuid,
                    n.status,
                    n.updated_at,
                    CONCAT(d.firstname, ' ', d.lastname) as doctor_name,
                    CONCAT(p.firstname, ' ', p.lastname) as patient_name
                FROM clinical_notes n
                INNER JOIN users d ON n.doctor_uuid = d.uuid
                INNER JOIN users p ON n.patient_uuid = p.uuid
                WHERE n.status = 'signed'
                ORDER BY n.updated_at DESC
                LIMIT 5
            ");
            $stmt->execute();
            $recent = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            return [
                'success' => true,
                'message' => 'Recent finalizations fetched successfully.',
                'data' => $recent
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Stats::getRecentFinalizations): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch recent finalizations.',
                'data' => []
            ];
        }
    }

    /**
     * Get quick stats for pending and critical notes based on created_at duration.
     * 
     * @return array
     */
    public static function getWidgetQuickStats(): array
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as pending_notes,
                    SUM(CASE WHEN status = 'draft' AND TIMESTAMPDIFF(HOUR, created_at, NOW()) > 72 THEN 1 ELSE 0 END) as critical_notes
                FROM clinical_notes
            ");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'message' => 'Quick stats fetched successfully.',
                'data' => [
                    'pending_notes' => (int) ($data['pending_notes'] ?? 0),
                    'critical_notes' => (int) ($data['critical_notes'] ?? 0),
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Stats::getWidgetQuickStats): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch quick stats.',
                'data' => [
                    'pending_notes' => 0,
                    'critical_notes' => 0,
                ]
            ];
        }
    }
}
