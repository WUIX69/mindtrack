<?php
require_once __DIR__ . '/../../../core/app.php';

/**
 * Authentication Login Server
 * Handles POST requests for user login
 */

apiHeaders();

use MindTrack\Models\Users;

try {
    // Only accept POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Invalid request method. Use POST request.';
        echo json_encode($response);
        exit;
    }

    // Get and validate input
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate required fields
    if (empty($username) || empty($password)) {
        $response['message'] = 'Username and password are required.';
        echo json_encode($response);
        exit;
    }

    // Check if login is via email or username
    $user = null;
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        // Login with email
        $user = Users::singleWhereEmail($username);
    } else {
        // Login with username
        $user = Users::singleWhereUsername($username);
    }

    // Verify user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Check if user is active
        if ($user['status'] !== 'active') {
            $response['message'] = 'Your account is not active. Please contact support.';
            echo json_encode($response);
            exit;
        }

        // Set session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['user_uuid'] = $user['uuid'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = time();

        session_write_close();

        // Update last login timestamp
        Users::updateLastLogin($user['uuid']);

        // Determine redirect route based on role
        $redirect_route = match ($user['role']) {
            'admin' => app('admin'),
            'doctor' => app('doctors'),
            'patient' => app('patients'),
            default => app('patients')
        };

        $response = array_merge($response, [
            'success' => true,
            'message' => "Welcome back, {$user['first_name']}!",
            'data' => [
                'route' => $redirect_route,
                'user' => [
                    'uuid' => $user['uuid'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'name' => $user['first_name'] . ' ' . $user['last_name'],
                    'role' => $user['role']
                ]
            ]
        ]);
    } else {
        // Invalid credentials
        $response['message'] = 'Invalid username/email or password!';
    }

} catch (Exception $e) {
    // Log error
    error_log('Login Error: ' . $e->getMessage());
    $response['message'] = 'An error occurred during login. Please try again later.';
}

echo json_encode($response);
exit;

