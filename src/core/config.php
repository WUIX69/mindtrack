<?php

// load environment variables using Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

$config = [
    'sub_folder' => 'mindtrack',
    'root_path' => dirname(__DIR__, 2),
    'uri_path' => $_SERVER['REQUEST_URI'] ?? null,
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'app' => [
        'base_url' => $_ENV['APP_URL'] ?? 'http://localhost/mindtrack',
        'assets_url' => '/public',
        'name' => $_ENV['APP_NAME'] ?? 'Mindtrack',
    ],
    'db' => [
        'development' => [
            'host' => '127.0.0.1',
            'name' => 'mindtrack',
            'port' => '3306',
            'username' => 'root',
            'password' => '',
        ],
        'production' => [
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'port' => $_ENV['DB_PORT'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
        ]
    ]
];

$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

$GLOBALS['config'] = $config;
$GLOBALS['response'] = $response;

