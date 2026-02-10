<?php
/**
 * Update Appointment Status Action (Admin Only)
 * Generic status changer for all 6 appointment statuses
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Get raw POST data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

try {
    // 1. Check Session & Role
    $user_uuid = $session->get('uuid');
    $user_type = $session->get('role');

    if (!$user_uuid || $user_type !== 'admin') {
        $response['message'] = 'Unauthorized. Admin access required.';
        echo json_encode($response);
        exit;
    }

    // 2. Validate Input
    $appointment_uuid = $input['appointment_uuid'] ?? null;
    $status = $input['status'] ?? null;

    if (!$appointment_uuid) {
        $response['message'] = 'Appointment UUID is required.';
        echo json_encode($response);
        exit;
    }

    if (!$status) {
        $response['message'] = 'Status is required.';
        echo json_encode($response);
        exit;
    }

    // 3. Validate Status Value (must be one of the 6 valid ENUM values)
    $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled', 'no_show', 'rescheduled'];
    if (!in_array($status, $validStatuses)) {
        $response['message'] = 'Invalid status. Must be one of: ' . implode(', ', $validStatuses);
        echo json_encode($response);
        exit;
    }

    // 4. Update Status
    $result = appointments::updateStatus($appointment_uuid, $status);

    if ($result['success']) {
        $response['success'] = true;
        $response['message'] = 'Appointment status updated successfully.';
    } else {
        $response['message'] = $result['message'];
    }

} catch (Exception $e) {
    error_log("Update Status Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
