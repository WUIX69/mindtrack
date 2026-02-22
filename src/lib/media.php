<?php

namespace Mindtrack\Lib;

use Mindtrack\Server\Db\Attachments;
use Mindtrack\Utils\Helpers;

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
                return Helpers::mediaUrl($item['reference_model'], $item['folder'], $item['filename']);
            }, $attachment ?? []);
        } else {
            return Helpers::mediaUrl($attachment['reference_model'], $attachment['folder'], $attachment['filename']);
        }
    }
}