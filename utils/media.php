<?php

use MindTrack\Models\Attachments;

function mediaHelper($dir = '', $folder = '', $filename = '')
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

function media($reference_uuid, $is_all = false)
{

    $attachment = [];
    if ($is_all) {
        $attachment = Attachments::all($reference_uuid)['data'] ?? [];
    } else {
        $attachment = Attachments::single($reference_uuid)['data'] ?? [];
    }

    if (empty($attachment)) {
        return asset('img/placeholders/image.png');
    }

    if ($is_all) {
        return array_map(function ($item) {
            return mediaHelper($item['reference_model'], $item['folder'], $item['filename']);
        }, $attachment ?? []);
    } else {
        return mediaHelper($attachment['reference_model'], $attachment['folder'], $attachment['filename']);
    }
}