<?php

namespace Mindtrack\Lib;

use Mindtrack\Server\Db\Attachments;

class Media
{
    public static function get($reference_uuid, $is_all = false)
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
}