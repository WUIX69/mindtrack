<?php

// load environment variables using Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$config = [
    'sub_folder' => 'mindtrack_tan',
    'root_path' => __DIR__ . '/../',  // Project root directory
    'uri_path' => $_SERVER['REQUEST_URI'],
    'app' => [
        'base_url' => $_ENV['APP_URL'] ?? 'http://localhost/mindtrack_tan',
        'assets_url' => '/assets',
        'name' => $_ENV['APP_NAME'] ?? 'MindTrack',
    ],
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'name' => $_ENV['DB_DATABASE'] ?? 'mindtrack_tan',
        'port' => $_ENV['DB_PORT'] ?? '3306',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ]
];

$response = [
    'success' => false,
    'message' => '',
    'data' => null
];
