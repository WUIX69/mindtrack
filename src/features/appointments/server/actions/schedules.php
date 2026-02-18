<?php

use Mindtrack\Server\Db\appointments;

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

// Ensure user is authenticated and is a doctor
if (!$session->get('uuid') || $session->get('role') !== 'doctor') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

$currentUserUuid = $session->get('uuid');
$action = $_GET['action'] ?? '';

try {
    // --- Handle GET Actions ---
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($action === 'fetch_range') {
            $startDate = $_GET['start'] ?? date('Y-m-d');
            $endDate = $_GET['end'] ?? date('Y-m-d', strtotime('+7 days'));

            $response = appointments::getRange($currentUserUuid, $startDate, $endDate);
        }
    }

    // --- Handle POST Actions ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;

        if ($action === 'store') {
            $data['doctor_uuid'] = $currentUserUuid;
            if (empty($data['uuid'])) {
                $data['uuid'] = uuid();
            }
            $response = appointments::store($data);
        }

        if ($action === 'update_status') {
            $uuid = $data['uuid'] ?? null;
            $status = $data['status'] ?? null;

            if ($uuid && $status) {
                $response = appointments::updateStatus($uuid, $status);
            } else {
                $response['message'] = 'Missing UUID or Status.';
            }
        }

        if ($action === 'delete') {
            $uuid = $data['uuid'] ?? null;

            if ($uuid) {
                $response = appointments::delete($uuid);
            } else {
                $response['message'] = 'Missing UUID.';
            }
        }
    }
} catch (Exception $e) {
    error_log("Schedule Action Error: " . $e->getMessage());
    $response['message'] = 'Server error occurred.';
}

echo json_encode($response);
exit;

