<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;

global $response;

$user_uuid = userData()['uuid'] ?? null;
if (!$user_uuid) {
    $response['message'] = 'User not authenticated.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';

    // Basic Validation
    if (empty($currentPassword) || empty($newPassword)) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit;
    }

    // Check if current password is correct
    $userResult = Users::single($user_uuid);
    $UserOGPassword = $userResult['data']['password'] ?? null;

    if (!password_verify($currentPassword, $UserOGPassword)) {
        $response['message'] = 'Current password is incorrect';
    }
    // Update password
    else {
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateResult = Users::updateWherePassword($hashedPassword, $user_uuid);
        $response = array_merge($response, $updateResult);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;