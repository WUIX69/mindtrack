<?php

declare(strict_types=1);

use Mindtrack\Features\Dashboard\Server\Db\QuickStats;

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

global $response;

$role = $session->get('role');
if (!$session->get('uuid') || !in_array($role, ['admin', 'doctor'])) {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'getAdminStats' && $role === 'admin') {
        $result = QuickStats::getAdminStats();
        $response = array_merge($response, $result);
    } elseif ($action === 'getDoctorStats' && $role === 'doctor') {
        $doctorUuid = $session->get('uuid');
        $result = QuickStats::getDoctorStats($doctorUuid);
        $response = array_merge($response, $result);
    } else {
        $response['message'] = 'Invalid action or permission denied.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;
