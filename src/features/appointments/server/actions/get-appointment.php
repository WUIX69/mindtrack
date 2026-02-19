<?php
/**
 * Get Single Appointment Action
 * Fetches full details for a specific appointment.
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

$uuid = $_GET['uuid'] ?? null;

if (!$uuid) {
    $response['message'] = 'Appointment UUID is required.';
    echo json_encode($response);
    exit;
}

try {
    // Check authentication
    $user_uuid = $session->get('uuid');
    if (!$user_uuid) {
        $response['message'] = 'Unauthorized.';
        echo json_encode($response);
        exit;
    }

    // Fetch appointment
    $result = appointments::getSingleAppointment($uuid);

    if (!$result['success']) {
        $response['message'] = $result['message'];
        echo json_encode($response);
        exit;
    }

    $appt = $result['data'];
    $user_role = $session->get('role');

    // ownership check
    $isAuthorized = false;

    if ($user_role === 'admin') {
        $isAuthorized = true;
    } elseif ($user_role === 'doctor') {
        if ($appt['doctor_uuid'] === $user_uuid) {
            $isAuthorized = true;
        }
    } else {
        // Patient
        if ($appt['patient_uuid'] === $user_uuid) {
            $isAuthorized = true;
        }
    }

    if (!$isAuthorized) {
        $response['message'] = 'Unauthorized access to this appointment.';
        echo json_encode($response);
        exit;
    }

    $result['viewer_role'] = $user_role;
    $response = array_merge($response, $result);

} catch (Exception $e) {
    error_log("Get Appointment Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
