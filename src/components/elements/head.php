<?php

$styles = [
    // 'vendor/fomantic-ui/dist/semantic.min.css',
    'fonts/fonts.css',
    'css/tailwind.css',
    'css/loader/window.css',
];

foreach ($styles as $style) {
    echo '<link rel="stylesheet" href="' . asset($style) . '">';
}

// Load Favicon
echo '<link rel="icon" type="image/png" href="' . asset('favicon.png') . '">';

// Load JQUERY, and Darkmode.js first
echo '<script src="' . asset('lib/jquery/jquery.min.js') . '"></script>';
echo '<script src="' . asset('js/darkmode.js') . '"></script>';