<?php

namespace VetSync\Utils\Php;

use DateTime;

class Formatters
{

    public static function dateToMDY($date = null)
    {
        if (!$date) {
            return '...';
        }

        $d = new DateTime($date);
        return $d->format('F j, Y'); // EG: December 12, 2024
    }

    public static function timeAgo($date = null)
    {
        if (!$date) {
            return '';
        }

        $providedTime = strtotime($date);
        $now = time();

        $timeDifference = $now - $providedTime;

        if ($timeDifference < 0) {
            return "Time is in the future";
        }

        $seconds = floor($timeDifference);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $years = floor($days / 365.25);

        // More efficient and readable approach using an array lookup:
        $units = [
            ['threshold' => 5, 'text' => "Just now"], // Special case for very recent
            ['threshold' => 60, 'unit' => "second", 'value' => $seconds],
            ['threshold' => 3600, 'unit' => "minute", 'value' => $minutes],
            ['threshold' => 86400, 'unit' => "hour", 'value' => $hours],
            ['threshold' => 31536000, 'unit' => "day", 'value' => $days],
            ['threshold' => PHP_FLOAT_MAX, 'unit' => "year", 'value' => $years] // Default case
        ];

        foreach ($units as $unit) {
            if ($seconds < $unit['threshold']) {
                if (isset($unit['text'])) {
                    return $unit['text'];
                }
                return $unit['value'] . " " . $unit['unit'] .
                    ($unit['value'] > 1 ? "s" : "") . " ago";
            }
        }

        return null;
    }

}
