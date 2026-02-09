<?php

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;

use Mindtrack\Schemas\Register;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Validate Data
$validation = Register::validate($_POST);
if (!$validation['valid']) {
    $response['message'] = 'Validation failed.';
    $response['errors'] = $validation['errors'];
    echo json_encode($response);
    exit;
}

$userData = $validation['data'];

// Check if user exists
if (!empty(Users::singleWhereEmail($userData['email']))) {
    $response['message'] = 'Email already registered.';
    echo json_encode($response);
    exit;
}

// Hash Password
$hashed_password = password_hash($userData['password'], PASSWORD_DEFAULT);

// Store User
$result = Users::store([
    'uuid' => uuid(),
    'firstname' => $userData['firstname'],
    'lastname' => $userData['lastname'],
    'email' => $userData['email'],
    'password' => $hashed_password,
    'phone' => $userData['phone'],
    'role' => 'patient'
]);
$response = array_merge($response, $result);

echo json_encode($response);
exit;