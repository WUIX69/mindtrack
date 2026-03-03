<?php

declare(strict_types=1);

use Mindtrack\Features\Patients\Server\Db\Stats;

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

global $response;

if (!$session->get('uuid') || $session->get('role') !== 'admin') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'getPatientsDemographic':
            $result = Stats::getPatientsDemographic();
            break;

        case 'getPatientsThisMonthChart':
            $result = Stats::getPatientsThisMonthChart();
            break;

        default:
            $result = [
                'success' => false,
                'message' => 'Invalid action.'
            ];
            break;
    }

    $response = array_merge($response, $result);
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;
