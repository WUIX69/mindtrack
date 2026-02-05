<?php

// load environment variables using Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

$config = [
    'sub_folder' => 'Mindtrack',
    'root_path' => $_SERVER['DOCUMENT_ROOT'],
    'uri_path' => $_SERVER['REQUEST_URI'],
    'app' => [
        'base_url' => $_ENV['APP_URL'],
        'assets_url' => '/public',
        'name' => $_ENV['APP_NAME'],
    ],
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'name' => $_ENV['DB_DATABASE'],
        'port' => $_ENV['DB_PORT'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$response = [
    'success' => false,
    'message' => '',
    'data' => null
];
