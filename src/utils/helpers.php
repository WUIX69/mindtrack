<?php

namespace Mindtrack\Utils;

use Throwable;

class Helpers
{
    public static function productStatus($status)
    {
        $default = [
            'icon' => 'circle outline grey',
            'label' => 'unknown',
        ];

        $statuses = [
            'available' => [
                'icon' => 'check circle green',
                'label' => 'available',
            ],
            'unavailable' => [
                'icon' => 'times circle red',
                'label' => 'unavailable',
            ],
        ];

        return $statuses[$status] ?? $default;
    }

    public static function serviceStatus($status)
    {
        $default = [
            'icon' => 'circle outline grey',
            'label' => 'unknown',
        ];

        $statuses = [
            'available' => [
                'icon' => 'check circle green',
                'label' => 'available',
            ],
            'unavailable' => [
                'icon' => 'times circle red',
                'label' => 'unavailable',
            ],
        ];

        return $statuses[$status] ?? $default;
    }

    public static function categoryName($category = [])
    {
        return [
            'icon' => $category['icon'] ?? 'folder outline grey',
            'label' => $category['name'] ?? 'Uncategorized',
        ];
    }

    public static function settingsUrlHandler($urls = null)
    {
        if (is_array($urls) && !empty($urls)) {
            // Remove empty values
            $filtered = array_filter($urls, function ($url) {
                return trim($url) !== '';
            });
            // Only implode if there are any non-empty values left
            return !empty($filtered) ? implode(',', $filtered) : null;
        }

        return null;
    }

    public static function mediaUrl($dir = '', $folder = '', $filename = '')
    {
        try {
            $fullPath = $dir . '/' . $folder . '/' . $filename;

            $source = urlFileHelper('uploads', $fullPath);
            if (!$source || $source == '') {
                return asset('img/placeholders/image.png');
            }

            return $source;
        } catch (Throwable $t) {
            error_log($t->getMessage());
            return null;
        }
    }
}