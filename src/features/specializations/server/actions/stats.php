<?php

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Features\Specializations\Server\Db\Stats;

global $response, $session;

if ($session->get('role') !== 'admin') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

$result = Stats::getOverviewStats();
$response = array_merge($response, $result);

echo json_encode($response);
exit;
