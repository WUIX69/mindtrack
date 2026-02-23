<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Features\Notes\Server\Db\Notes;

// Initialize global response
global $response;

// Ensure user is authenticated
$validRoles = ['doctor', 'patient'];
if (!$session->get('uuid') || !in_array($session->get('role'), $validRoles)) {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

$userUuid = $session->get('uuid');
$userRole = $session->get('role');
$method = $_SERVER['REQUEST_METHOD'];

// Handle GET Requests
if ($method === 'GET') {
    $uuid = $_GET['uuid'] ?? null;

    if (!$uuid) {
        $response['message'] = 'Note UUID is required.';
        echo json_encode($response);
        exit;
    }

    $noteResult = Notes::singleDetailed($uuid);

    // Security check for patients
    if ($userRole === 'patient' && $noteResult['success'] && !empty($noteResult['data'])) {
        if ($noteResult['data']['patient_uuid'] !== $userUuid) {
            $response['success'] = false;
            $response['message'] = 'Unauthorized to view this note.';
            $response['data'] = null;
            echo json_encode($response);
            exit;
        }
    }

    $response = array_merge($response, $noteResult);

    echo json_encode($response);
    exit;
}

$response['message'] = 'Invalid request method.';
echo json_encode($response);
exit;
