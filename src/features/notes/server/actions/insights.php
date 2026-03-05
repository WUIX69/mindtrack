<?php

declare(strict_types=1);

use Mindtrack\Features\Notes\Server\Db\Insights;

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

global $response, $session;

if (!$session->get('uuid') || $session->get('role') !== 'patient') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $patientUuid = $session->get('uuid');
    $result = Insights::getPatientInsights($patientUuid);
    $response = array_merge($response, $result);
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;
