<?php

use Mindtrack\Lib\SessionManager;

$sessionName = $_ENV['SESSION_NAME'] ?? 'Mindtrack_SESSION';

// Start the session if not already started
session_name($sessionName);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Instantiate the session manager
// $session = new SessionManager();

// Check path type once to avoid multiple function calls
// $sessionPathType = null;
// if (uriAppPath('user')) {
//     $sessionPathType = 'user';
// } elseif (uriAppPath('admin')) {
//     $sessionPathType = 'admin';
// } elseif (uriAppPath('auth')) {
//     $sessionPathType = 'auth';
// }

// Handle authentication and access control
// if (($sessionPathType === 'user' || $sessionPathType === 'admin') && !$session->has()) {
//     // Redirect to landing page if accessing restricted area without session
//     header("Location: " . app('landing'));
//     exit;

// } elseif ($sessionPathType === 'auth' && $session->has()) {
//     // Destroy existing session when accessing auth pages
//     $session->destroy();

// } elseif ($session->has()) {
//     // Handle incorrect area access based on account type
//     $sessionType = $session->get()['type'] ?? null;
//     if (
//         ($sessionType === 'user' && $sessionPathType === 'admin') ||
//         ($sessionType === 'admin' && $sessionPathType === 'user')
//     ) {
//         header("Location: " . app($sessionType));
//         exit;
//     }
// }

// Debug session data
// error_log(print_r($session->get(), true));
