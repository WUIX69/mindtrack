<?php

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