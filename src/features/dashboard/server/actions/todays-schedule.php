<?php

declare(strict_types=1);

use Mindtrack\Server\Db\appointments;

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

global $response;

if (!$session->get('uuid') || !in_array($session->get('role'), ['admin', 'doctor'])) {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $doctorUuid = $session->get('role') === 'doctor' ? $session->get('uuid') : null;
    $result = appointments::allWhereDoctorTodaysSchedule($doctorUuid);
    $response = array_merge($response, $result);
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;
