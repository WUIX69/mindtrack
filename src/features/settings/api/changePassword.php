<?php

include '../../../core/app.php';
apiHeaders();

use Mindtrack\Models\Users;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $user_uuid = userData()['uuid'] ?? null;
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    // Check if current password is correct
    $UserOGPassword = Users::single($user_uuid)['data']['password'] ?? null;
    if (!password_verify($currentPassword, $UserOGPassword)) {
        $response['message'] = 'Current password is incorrect';
    }
    // Update password
    else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash new password
        $response = Users::updateWherePassword($hashedPassword, $user_uuid);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;