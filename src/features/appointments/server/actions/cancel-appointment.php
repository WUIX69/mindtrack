<?php
/**
 * Cancel Appointment Action
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;
use Mindtrack\Server\Db\Users;
use Mindtrack\Lib\Notify;

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
        $check = appointments::allWherePatients($user_uuid);
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

        // Send Notifications
        $appt = appointments::single($appointment_uuid);
        if ($appt) {
            $formattedDate = date('M j, Y', strtotime($appt['sched_date']));
            $notifyData = [
                'type' => 'appointment_cancelled',
                'title' => 'Appointment Cancelled',
                'description' => "The appointment on $formattedDate has been cancelled.",
                'icon' => 'event_busy',
                'color' => 'red'
            ];

            $notify = new Notify();

            // Notify admins
            $notify->send($user_uuid, $notifyData['type'], $notifyData, 'admin', 'all');

            // Notify the other party
            if ($user_type === 'patient') {
                // Patient cancelled -> Notify doctor
                $notify->send($appt['doctor_uuid'], $notifyData['type'], $notifyData);
            } elseif ($user_type === 'doctor') {
                // Doctor cancelled -> Notify patient
                $notify->send($appt['patient_uuid'], $notifyData['type'], $notifyData);
            } else {
                // Admin cancelled -> Notify both
                $notify->send($appt['patient_uuid'], $notifyData['type'], $notifyData);
                $notify->send($appt['doctor_uuid'], $notifyData['type'], $notifyData);
            }
        }

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
