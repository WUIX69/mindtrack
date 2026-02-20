<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Features\Auth\Schemas\Login;
use Mindtrack\Server\Db\Users;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {
    // Validate Data
    $validation = Login::validate($_POST);
    if (!$validation['valid']) {
        $response['message'] = 'Validation failed.';
        $response['errors'] = $validation['errors'];
        echo json_encode($response);
        exit;
    }

    $userData = $validation['data'];
    $user = Users::singleWhereEmail($userData['email']);

    if ($user && password_verify($userData['password'], $user['password'] ?? '')) {
        // Enforce email verification (super admin might bypass this if needed, but for patient/doctor it's required)
        if (isset($user['is_email_verified']) && $user['is_email_verified'] == 0 && in_array($user['role'] ?? 'patient', ['patient', 'doctor'])) {
            $response['message'] = 'Please verify your email address before logging in. Check your inbox for the verification link.';
            echo json_encode($response);
            exit;
        }

        $role = $user['role'] ?? 'patient'; // Default to patient if role is missing

        $session->set($user);
        $session->update(['role' => $role]);

        $response = array_merge($response, [
            'success' => true,
            'message' => 'Welcome back!',
            'data' => [
                'route' => app($role),
            ],
        ]);
    } else {
        $response['message'] = 'Invalid email and/or password!';
    }
} catch (Exception $e) {
    error_log("Login Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
