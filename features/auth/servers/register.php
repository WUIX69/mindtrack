<?php
require_once __DIR__ . '/../../../core/app.php';

/**
 * User Registration Server
 * Handles POST requests for user registration
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
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $role = trim($_POST['role'] ?? 'patient');

    // Role-specific fields removed - all fields are now basic

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($password)) {
        $response['message'] = 'All required fields must be filled.';
        echo json_encode($response);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please enter a valid email address.';
        echo json_encode($response);
        exit;
    }

    // Validate password length
    if (strlen($password) < 6) {
        $response['message'] = 'Password must be at least 6 characters long.';
        echo json_encode($response);
        exit;
    }

    // Validate password confirmation
    if ($password !== $confirm_password) {
        $response['message'] = 'Passwords do not match.';
        echo json_encode($response);
        exit;
    }

    // Validate role
    $allowed_roles = ['patient', 'doctor', 'admin'];
    if (!in_array($role, $allowed_roles)) {
        $role = 'patient'; // Default to patient if invalid role
    }

    // Role-specific fields are now optional (database allows NULL)
    // No additional validation needed for role-specific fields

    // Check if email already exists
    if (Users::emailExists($email)) {
        $response['message'] = 'Email address is already registered.';
        echo json_encode($response);
        exit;
    }

    // Check if username already exists
    if (Users::usernameExists($username)) {
        $response['message'] = 'Username is already taken.';
        echo json_encode($response);
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare user data
    $userData = [
        'uuid' => generateUUID(),
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'username' => $username,
        'password' => $hashed_password,
        'phone' => $phone ?: null,
        'role' => $role,
        'status' => 'active'
    ];

    // Role-specific data removed - all users get basic registration

    // Store user in database
    $result = Users::store($userData);

    if ($result['success']) {
        // Registration successful - redirect to login page
        $response = array_merge($response, [
            'success' => true,
            'message' => 'Registration successful! Please login with your credentials.',
            'data' => [
                'route' => app('auth'), // Redirect to login page
                'user' => [
                    'uuid' => $userData['uuid'],
                    'username' => $username,
                    'email' => $email,
                    'role' => $role
                ]
            ]
        ]);
    } else {
        $response['message'] = 'Registration failed. Please try again.';
    }

} catch (Exception $e) {
    // Log error with more details
    error_log('Registration Error: ' . $e->getMessage());
    error_log('Registration Error Trace: ' . $e->getTraceAsString());
    error_log('Registration Data: ' . json_encode($_POST));
    $response['message'] = 'An error occurred during registration. Please try again later.';
    $response['debug'] = $e->getMessage(); // Remove this in production
}

echo json_encode($response);
exit;

