<?php
/**
 * Cancel Appointment Action
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;

$input = json_decode(file_get_contents('php://input'), true);
$appointment_uuid = $input['appointment_uuid'] ?? null;

if (!$appointment_uuid) {
    $response['message'] = 'Appointment ID is required.';
    echo json_encode($response);
    exit;
}

try {
    $user_uuid = $session->get('uuid');
    $user_type = $session->get('role');

    if (!$user_uuid) {
        $response['message'] = 'Unauthorized.';
        echo json_encode($response);
        exit;
    }

    $isOwner = false;

    if ($user_type === 'admin') {
        $isOwner = true;
    } else {
        // Double check ownership for patients
        $check = appointments::allWherePatient($user_uuid);
        if ($check['success']) {
            foreach ($check['data'] as $appt) {
                if ($appt['uuid'] === $appointment_uuid) {
                    $isOwner = true;
                    break;
                }
            }
        }
    }

    if (!$isOwner) {
        $response['message'] = 'You do not have permission to modify this appointment.';
        echo json_encode($response);
        exit;
    }

    $result = appointments::updateStatus($appointment_uuid, 'cancelled');

    if ($result['success']) {
        $response['success'] = true;
        $response['message'] = 'Appointment withdrawn successfully.';
        $response = array_merge($response, $result);
    } else {
        $response['message'] = $result['message'];
    }
} catch (Exception $e) {
    error_log("Cancel Appointment Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}
echo json_encode($response);
exit;
exit;
