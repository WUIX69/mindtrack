<?php

$appDirName = uriAppPath();
$styles = [
    'vendor/fomantic-ui/dist/semantic.min.css',
    'css/tailwind.css',
    'css/loader/window.css',
];

foreach ($styles as $style) {
    echo '<link rel="stylesheet" href="' . asset($style) . '">';
}

// Load Favicon
echo '<link rel="icon" type="image/png" href="' . asset('favicon.png') . '">';

// Load JQUERY first
echo '<script src="' . asset('lib/jquery/jquery.min.js') . '"></script>';