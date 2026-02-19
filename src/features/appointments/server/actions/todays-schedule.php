<?php

use Mindtrack\Server\Db\appointments;

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

global $response;

// Ensure user is authenticated and is a doctor
if (!$session->get('uuid') || $session->get('role') !== 'doctor') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

$doctorUuid = $session->get('uuid');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = appointments::allWhereDoctorTodaysSchedule($doctorUuid);
    $response = array_merge($response, $result);
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;
