<?php

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Get POST data and sanitize
$firstname = htmlspecialchars(strip_tags($_POST['firstname'] ?? ''));
$lastname = htmlspecialchars(strip_tags($_POST['lastname'] ?? ''));
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone = !empty($_POST['phone']) ? htmlspecialchars(strip_tags($_POST['phone'])) : null;
$password = $_POST['password'] ?? '';

// Check if user exists (Business Logic - Keeping it)
if (!empty(Users::singleWhereEmail($email))) {
    $response['message'] = 'Email already registered.';
    echo json_encode($response);
    exit;
}

// Hash Password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Store User
$result = Users::store([
    'uuid' => uuid(),
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'password' => $hashed_password,
    'phone' => $phone,
    'role' => 'patient'
]);
$response = array_merge($response, $result);

echo json_encode($response);
exit;