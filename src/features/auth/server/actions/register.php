<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
use Mindtrack\Features\Auth\Schemas\Register;
use Mindtrack\Lib\Email;
use Mindtrack\Lib\Notify;

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
$verificationToken = uuid();
$result = Users::store([
    'uuid' => uuid(),
    'email_verification_token' => $verificationToken,
    'firstname' => $userData['firstname'],
    'lastname' => $userData['lastname'],
    'email' => $userData['email'],
    'password' => $hashed_password,
    'phone' => $userData['phone'],
    'role' => 'patient'
]);

// Send Verification Email and Notifications
if ($result['success']) {
    $email_response = Email::sendVerificationEmail($userData['email'], $userData['firstname'], $userData['lastname'], $verificationToken);
    $response['email_response'] = $email_response;

    $notifyData = [
        'type' => 'new_registration',
        'title' => 'New Patient Registered',
        'description' => $userData['firstname'] . ' ' . $userData['lastname'] . ' just signed up.',
        'icon' => 'person_add',
        'color' => 'purple'
    ];

    $notify = new Notify();
    $notify->send(null, $notifyData['type'], $notifyData, 'admin', 'all');
}

$response = array_merge($response, $result);
echo json_encode($response);
exit;
