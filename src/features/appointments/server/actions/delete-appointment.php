<?php
/**
 * Delete Appointment Action (Admin Only)
 * Hard delete - permanently removes appointment from database
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

    if (!$appointment_uuid) {
        $response['message'] = 'Appointment UUID is required.';
        echo json_encode($response);
        exit;
    }

    // 3. Delete Appointment
    $result = appointments::delete($appointment_uuid);

    if ($result['success']) {
        $response['success'] = true;
        $response['message'] = 'Appointment deleted successfully.';
    } else {
        $response['message'] = $result['message'];
    }

} catch (Exception $e) {
    error_log("Delete Appointment Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
