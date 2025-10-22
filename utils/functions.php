<?php

function baseURL($path = '')
{
    global $config;
    // Get the protocol and host only once per page load
    static $baseUrl = null;

    // Get the base URL if it's not already set
    if ($baseUrl === null) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $baseUrl = $protocol . '://' . $host . '/' . $config['sub_folder'] . '/';
    }

    // Return base URL if no path provided
    if (empty($path)) {
        return rtrim($baseUrl, '/');
    }

    // Append the path (already has trailing slash from $baseUrl)
    return $baseUrl . ltrim($path, '/');
}

function includeFileHelper($dir, $file)
{
    global $config;

    // Use the root_path from config for accurate path resolution
    $root_path = $config['root_path'] ?? dirname(__DIR__);

    // Build the directory path
    $dir_path = $root_path . '/' . ($dir ? $dir . '/' : '');

    // Construct the full path to the file
    $file_path = $dir_path . $file . '.php';

    try {
        if (!file_exists($file_path)) {
            throw new Exception("File not found: $file_path");
        }
        include $file_path; // Include the file
    } catch (Exception $e) {
        error_log("Shared file Error: " . $e->getMessage());
        error_log("Attempted path: " . $file_path);
    }
}

function urlFileHelper($dir, $file, $is_asset = false)
{
    global $config;

    // Define the directory where your source files are located
    $dir_path = $is_asset ? 'assets' : $dir;
    $url = $dir_path . '/' . ltrim($file, '/');

    // Check if the file exists
    $checkUrlPath = $config['root_path'] . '/' . $url;
    if (file_exists($checkUrlPath)) {
        return baseURL($url); // Return the URL of the source file
    }

    return '';
}

function asset($file)
{
    return urlFileHelper('assets', $file, true);
}

function shared($file, $is_url = false)
{
    if ($is_url)
        return urlFileHelper('', $file);
    includeFileHelper('', $file);
}

function featured($path, $is_url = false)
{
    if ($is_url)
        return urlFileHelper('features', $path);
    includeFileHelper('features', $path);
}

function utils($file, $is_url = false)
{
    if ($is_url)
        return urlFileHelper('utils', $file);
    includeFileHelper('utils', $file);
}

function app($link = '')
{
    // Handle empty link case
    if (empty($link)) {
        return urlFileHelper('app', 'landing');
    }

    // Check if the link ends with a trailing slash (indicating a directory)
    if (substr($link, -1) === '/') {
        $url = $link . 'index.php';
    }
    // Check if the link has no slashes (just a directory name)
    elseif (strpos($link, '/') === false) {
        $url = $link . '/index.php';
    }
    // Handle paths with subdirectories
    else {
        // Check if the path contains a file extension
        if (preg_match('/\.[a-zA-Z0-9]+$/', $link)) {
            // If it already has an extension, use it as is
            $url = $link;
        } else {
            // No extension, so add .php
            $url = $link . '.php';
        }
    }

    // Ensure we have the .php extension
    if (substr($url, -4) !== '.php') {
        $url .= '.php';
    }

    return urlFileHelper('app', $url);
}

function uriAppPath($path = null)
{
    global $config;

    $uriPath = $config['uri_path'] ?? '';
    $pathResult = "";

    if ($path) {
        $pathResult = strpos($uriPath, "/$path/") !== false;
    } else {
        $pathResult = explode('/', trim($uriPath, '/'))[2] ?? ''; // [0] is the src, [1] is the app, [2] is the app path
    }

    return $pathResult;
}

function uriPagePath()
{
    global $config;

    $urlPath = $config['uri_path'] ?? '';
    $urlParts = explode('/', trim($urlPath, '/')) ?? '';

    // Loop through urlParts to find a file with .php extension
    $pageName = '';
    foreach ($urlParts as $part) {
        // Found a file with .php extension
        if (strpos($part, '.php') !== false) {
            // Extract only the filename part before any query parameters
            $filenamePart = explode('?', $part)[0];
            $pageName = str_replace('.php', '', $filenamePart);
            break;
        }
    }

    $activeLink = str_replace('.php', '', $pageName);
    return $activeLink;
}

function apiHeaders()
{
    // Prevent caching for dynamic content
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    // Set content type and charset
    header('Content-Type: application/json; charset=utf-8');

    // Security headers
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
}