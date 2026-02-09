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
    echo json_encode(['success' => false, 'message' => 'Appointment ID is required.']);
    exit;
}

try {
    $patient_uuid = $session->get('uuid');
    if (!$patient_uuid) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
        exit;
    }

    // Double check ownership before updating
    // We'll fetch all patient appointments and check if the UUID exists in the set
    $check = appointments::allWherePatient($patient_uuid);
    $isOwner = false;

    if ($check['success']) {
        foreach ($check['data'] as $appt) {
            if ($appt['uuid'] === $appointment_uuid) {
                $isOwner = true;
                break;
            }
        }
    }

    if (!$isOwner) {
        echo json_encode(['success' => false, 'message' => 'You do not have permission to modify this appointment.']);
        exit;
    }

    $result = appointments::updateStatus($appointment_uuid, 'cancelled');

    if ($result['success']) {
        echo json_encode(['success' => true, 'message' => 'Appointment withdrawn successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }
} catch (Exception $e) {
    error_log("Cancel Appointment Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An internal error occurred.']);
}
exit;
