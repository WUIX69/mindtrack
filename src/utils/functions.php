<?php

use function PHPUnit\Framework\isEmpty;

function baseURL($path = '')
{
    global $config;

    // Get the protocol and host only once per page load
    static $baseUrl = null;

    // Get the base URL if it's not already set
    if ($baseUrl === null) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $subFolder = isset($config['sub_folder']) && !empty($config['sub_folder']) ? $config['sub_folder'] . '/' : '';
        $baseUrl = $protocol . '://' . $host . '/' . $subFolder;
    }

    // Return base URL if no path provided
    if (empty($path)) {
        return $baseUrl;
    }

    // Append the path
    return $baseUrl . ltrim($path, '/');
}

function includeFileHelper($dir, $file, $data = [])
{
    // Define the directory where your files are located
    $dir_path = dirname(__DIR__) . '/' . $dir . '/';

    // Construct the full path to the file
    $file_path = $dir_path . $file . '.php';

    try {
        if (!file_exists($file_path)) {
            throw new Exception("File not found: $file_path");
        }

        // Extract data to make it available in the included file
        if (!empty($data) && is_array($data)) {
            extract($data);
        }

        include $file_path;
    } catch (Throwable $t) {
        error_log("$dir file Error, " . $t->getMessage());
    }
}

function urlFileHelper($dir, $file, $is_public = false)
{
    global $config;

    // Define the directory where your source files are located
    $dir_path = $is_public ? 'public' : "src/$dir";
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
    return urlFileHelper('public', $file, true);
}

function shared($folder = "", $file = null, $data = [], $is_url = false)
{
    // Backward compatibility for when $is_url was the 3rd argument
    if (is_bool($data)) {
        $is_url = $data;
        $data = [];
    }

    // shared folder is in src folder (e.g, components, lib, utils, data, schemas, server, utils)
    if ($is_url)
        return urlFileHelper($folder, $file);
    includeFileHelper($folder, $file, $data);
}

function featured($feat_name = "", $file = null, $data = [], $is_url = false)
{
    // Backward compatibility for when $is_url was the 2nd argument
    if (is_bool($data)) {
        $is_url = $data;
        $data = [];
    }

    $path = $feat_name . '/' . $file;

    if ($is_url)
        return urlFileHelper('features', $path);
    includeFileHelper('features', $path, $data);
}

function partial($file = null, $data = [])
{
    $appName = uriAppPath();
    $path = "app/{$appName}/components";
    includeFileHelper($path, $file, $data);
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