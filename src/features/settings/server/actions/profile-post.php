<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Lib\FileManager;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $user_uuid = $session->get('uuid') ?? userData()['uuid'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($action === 'profile-upload') {

        $fileManager = new FileManager();
        $response = $fileManager->storeWhereInstant($_FILES['profile'], 'profiles', $user_uuid);
        $response['data']['profile_url'] = userData()['profile'];

    } else {
        $response['message'] = 'Invalid profile action';
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
