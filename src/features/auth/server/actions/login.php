<?php

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $response['message'] = 'Please fill in all fields.';
        echo json_encode($response);
        exit;
    }

    $user = Users::singleWhereEmail($email);

    if ($user && password_verify($password, $user['password'] ?? '')) {
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
