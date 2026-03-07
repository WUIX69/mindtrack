<?php
/**
 * Confirm Appointment Action (Admin Only)
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;
use Mindtrack\Server\Db\Users;
use Mindtrack\Lib\Notify;

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

    // 3. Confirm Appointment
    $result = appointments::confirm($appointment_uuid);

    if ($result['success']) {
        $response['success'] = true;
        $response['message'] = 'Appointment confirmed successfully.';

        // Send Notifications
        $appt = appointments::single($appointment_uuid);
        if ($appt) {
            $formattedDate = date('M j, Y', strtotime($appt['sched_date']));
            $notifyData = [
                'type' => 'appointment_confirmed',
                'title' => 'Appointment Confirmed',
                'description' => "Your appointment on $formattedDate has been confirmed by admin.",
                'icon' => 'event_available',
                'color' => 'green'
            ];

            $notify = new Notify();

            // Notify patient and doctor
            $notify->send($appt['patient_uuid'], $notifyData['type'], $notifyData);
            $notify->send($appt['doctor_uuid'], $notifyData['type'], $notifyData);
        }

    } else {
        $response['message'] = $result['message'];
    }

} catch (Exception $e) {
    error_log("Confirm Appointment Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
