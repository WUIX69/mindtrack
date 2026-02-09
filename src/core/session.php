<?php

use Mindtrack\Lib\SessionManager;

$sessionName = $_ENV['SESSION_NAME'] ?? 'MINDTRACK_SESSION';
$session = new SessionManager($sessionName);

// Define app roles
$roles = ['patient', 'doctor', 'admin'];

// Detect current path territory
$territory = null;
foreach (array_merge($roles, ['auth']) as $role) {
    if (uriAppPath($role)) {
        $territory = $role;
        break;
    }
}

// Redirect logic
if (in_array($territory, $roles)) {
    // Restricted areas
    if (!$session->has()) {
        header("Location: " . app('auth'));
        exit;
    }

    $userRole = $session->get('role') ?? $session->get('type');
    if ($userRole !== $territory) {
        header("Location: " . app($userRole));
        exit;
    }
} elseif ($territory === 'auth') {
    // Auth area (sign-in/sign-up)
    if ($session->has()) {
        $userRole = $session->get('role') ?? $session->get('type');
        header("Location: " . app($userRole));
        exit;
    }
}
