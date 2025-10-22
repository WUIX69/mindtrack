<?php
global $config;

// Include jQuery 3.4+ before Fomantic
echo '<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>';

// Include Font Awesome
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">';

// Include Fomantic UI CSS
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.4/dist/semantic.min.css">';

// Include Tailwind CSS (v3 CDN - stable version)
echo '<script src="https://cdn.tailwindcss.com"></script>';

// Load Favicon (if exists)
$favicon_path = $config['root_path'] . 'assets/favicon.png';
if (file_exists($favicon_path)) {
    echo '<link rel="icon" type="image/png" href="' . asset('favicon.png') . '">';
}