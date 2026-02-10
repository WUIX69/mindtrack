<?php

require_once dirname(__DIR__, 5) . '/src/core/app.php';
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
