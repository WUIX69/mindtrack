<?php

// Simple session initialization
// More complex session management can be added later if needed

$sessionName = $_ENV['SESSION_NAME'] ?? 'MINDTRACK_SESSION';

// Start the session if not already started
session_name($sessionName);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Optional: Instantiate the session manager if needed
// Uncomment the following lines when you need advanced session management
/*
use MindTrack\Services\SessionManager;
$session = new SessionManager();

// Check path type once to avoid multiple function calls
$sessionPathType = null;
if (uriAppPath('patients')) {
    $sessionPathType = 'patients';
} elseif (uriAppPath('doctors')) {
    $sessionPathType = 'doctors';
}

// Handle authentication and access control
if (($sessionPathType === 'patients' || $sessionPathType === 'doctors') && !$session->has()) {
    // Redirect to landing page if accessing restricted area without session
    header("Location: " . app('landing'));
    exit;

} elseif ($sessionPathType === 'auth' && $session->has()) {
    // Destroy existing session when accessing auth pages
    $session->destroy();

} elseif ($session->has()) {
    // Handle incorrect area access based on account type
    $sessionType = $session->get()['type'] ?? null;
    if (
        ($sessionType === 'patients' && $sessionPathType === 'doctors') ||
        ($sessionType === 'doctors' && $sessionPathType === 'patients')
    ) {
        header("Location: " . app($sessionType));
        exit;
    }
}
*/
