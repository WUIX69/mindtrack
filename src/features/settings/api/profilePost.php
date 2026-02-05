<?php

include '../../../core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
use Mindtrack\Lib\FileManager;
use Mindtrack\Utils\Helpers;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $user_uuid = userData()['uuid'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($action === 'profile-upload') {

        $fileManager = new FileManager();
        $response = $fileManager->storeWhereInstant($_FILES['profile'], 'profiles', $user_uuid);
        $response['data']['profile_url'] = userData()['profile'];

    } else if ($action === 'profile-update') {

        $data = [
            'user_uuid' => $user_uuid,
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'telephone' => $_POST['telephone'],
            'dob' => $_POST['dob'],
            'email' => $_POST['email'],
            'location' => $_POST['location'],
            'bio' => $_POST['bio'] ? $_POST['bio'] : null,
            'urls' => Helpers::settingsUrlHandler($_POST['urls']),
        ];

        // Update profile
        $response = Users::update($data);

    } else {
        $response['message'] = 'Invalid profile action';
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
