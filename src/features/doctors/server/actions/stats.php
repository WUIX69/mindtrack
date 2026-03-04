<?php

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Features\Doctors\Server\Db\Stats;

global $response, $session;

if ($session->get('role') !== 'admin') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getCapacityOverview':
        $result = Stats::getCapacityOverview();
        $response = array_merge($response, $result);
        break;

    case 'getSpecialtyDistribution':
        $result = Stats::getSpecialtyDistribution();
        $response = array_merge($response, $result);
        break;

    default:
        $response['message'] = 'Invalid action or action not specified.';
}

echo json_encode($response);
exit;
