<?php

declare(strict_types=1);

namespace Mindtrack\Features\Patients\Server\Db;

use Mindtrack\Server\Db\Base;
use PDO;
use PDOException;

class Stats extends Base
{
    /**
     * Get patient demographics broken down by age groups
     * 
     * @return array
     */
    public static function getPatientsDemographic(): array
    {
        try {
            $stmt = self::conn()->prepare("
                SELECT
                    SUM(CASE WHEN age >= 18 AND age < 65 THEN 1 ELSE 0 END) as adults,
                    SUM(CASE WHEN age >= 12 AND age < 18 THEN 1 ELSE 0 END) as adolescents,
                    SUM(CASE WHEN age >= 65 THEN 1 ELSE 0 END) as seniors,
                    COUNT(*) as total
                FROM (
                    SELECT TIMESTAMPDIFF(YEAR, pi.date_of_birth, CURDATE()) as age
                    FROM users u
                    INNER JOIN user_patient_info pi ON u.uuid = pi.user_uuid
                    WHERE u.role = 'patient' AND pi.date_of_birth IS NOT NULL
                ) age_data
            ");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            // Calculate percentages
            $total = (int) ($data['total'] ?? 0);
            $adults = (int) ($data['adults'] ?? 0);
            $adolescents = (int) ($data['adolescents'] ?? 0);
            $seniors = (int) ($data['seniors'] ?? 0);

            $adultsPercent = $total > 0 ? round(($adults / $total) * 100) : 0;
            $adolescentsPercent = $total > 0 ? round(($adolescents / $total) * 100) : 0;
            $seniorsPercent = $total > 0 ? round(($seniors / $total) * 100) : 0;

            return [
                'success' => true,
                'message' => 'Demographics fetched successfully.',
                'data' => [
                    'adults' => $adults,
                    'adolescents' => $adolescents,
                    'seniors' => $seniors,
                    'total' => $total,
                    'adults_percent' => $adultsPercent,
                    'adolescents_percent' => $adolescentsPercent,
                    'seniors_percent' => $seniorsPercent,
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Stats::getPatientsDemographic): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch demographics.',
                'data' => [
                    'adults' => 0,
                    'adolescents' => 0,
                    'seniors' => 0,
                    'total' => 0,
                    'adults_percent' => 0,
                    'adolescents_percent' => 0,
                    'seniors_percent' => 0
                ]
            ];
        }
    }

    /**
     * Get new patients count for this month, growth %, and 7-week breakdown
     * 
     * @return array
     */
    public static function getPatientsThisMonthChart(): array
    {
        try {
            // 1. Get current month count
            $stmt1 = self::conn()->prepare("
                SELECT COUNT(*) as current_month
                FROM users 
                WHERE role = 'patient'
                AND created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
            ");
            $stmt1->execute();
            $currentMonth = (int) ($stmt1->fetchColumn() ?: 0);

            // 2. Get previous month count
            $stmt2 = self::conn()->prepare("
                SELECT COUNT(*) as previous_month
                FROM users 
                WHERE role = 'patient'
                AND created_at >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')
                AND created_at < DATE_FORMAT(CURDATE(), '%Y-%m-01')
            ");
            $stmt2->execute();
            $previousMonth = (int) ($stmt2->fetchColumn() ?: 0);

            // Calculate growth percent
            $growthPercent = 0;
            if ($previousMonth > 0) {
                $growthPercent = round((($currentMonth - $previousMonth) / $previousMonth) * 100);
            } else if ($currentMonth > 0) {
                $growthPercent = 100; // From 0 to some is 100% growth
            }

            // 3. Weekly breakdown for chart (last 7 weeks)
            $stmt3 = self::conn()->prepare("
                SELECT 
                    YEARWEEK(created_at, 1) as week_num,
                    COUNT(*) as count
                FROM users 
                WHERE role = 'patient'
                AND created_at >= CURDATE() - INTERVAL 7 WEEK
                GROUP BY YEARWEEK(created_at, 1)
                ORDER BY week_num ASC
            ");
            $stmt3->execute();
            $weeklyRecords = $stmt3->fetchAll(PDO::FETCH_ASSOC) ?? [];

            // We need exactly 7 bars for the UI, so we pad the array
            // Even if there are missing weeks, we just take the last 7 values or pad with 0s
            $chartData = [];
            foreach ($weeklyRecords as $record) {
                $chartData[] = (int) $record['count'];
            }

            // Pad or trim to exactly 7 items
            while (count($chartData) < 7) {
                array_unshift($chartData, 0); // pad at the beginning for older weeks
            }
            if (count($chartData) > 7) {
                $chartData = array_slice($chartData, -7);
            }

            return [
                'success' => true,
                'message' => 'Growth chart fetched successfully.',
                'data' => [
                    'current_month' => $currentMonth,
                    'previous_month' => $previousMonth,
                    'growth_percent' => $growthPercent,
                    'weekly_breakdown' => $chartData,
                ]
            ];
        } catch (PDOException $e) {
            error_log("SQL Error (Stats::getPatientsThisMonthChart): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch growth chart data.',
                'data' => [
                    'current_month' => 0,
                    'previous_month' => 0,
                    'growth_percent' => 0,
                    'weekly_breakdown' => array_fill(0, 7, 0),
                ]
            ];
        }
    }
}
