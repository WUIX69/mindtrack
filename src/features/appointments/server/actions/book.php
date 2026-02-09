<?php
/**
 * Appointment Booking Action
 * Standardized with API headers and Schema validation.
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;
use Mindtrack\Schemas\Appointment;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Get raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    // Try regular POST if JSON decode fails
    $input = $_POST;
}

try {
    // Validate Data
    $validation = Appointment::validate($input);
    if (!$validation['valid']) {
        $response['message'] = 'Validation failed.';
        $response['errors'] = $validation['errors'];
        echo json_encode($response);
        exit;
    }

    $validData = $validation['data'];
    $patient_uuid = $session->get('uuid');

    if (!$patient_uuid) {
        $response['message'] = 'User session not found. Please log in again.';
        echo json_encode($response);
        exit;
    }

    // Prepare data for storage
    $data = [
        'uuid' => uuid(),
        'patient_uuid' => $patient_uuid,
        'doctor_uuid' => $validData['doctor_uuid'],
        'service_uuid' => $validData['service_uuid'],
        'sched_date' => $validData['sched_date'],
        'sched_time' => $validData['sched_time'],
        'status' => 'pending',
        'notes' => $validData['notes'] ?? null
    ];

    $result = appointments::store($data);

    if ($result['success']) {
        $response['success'] = true;
        $response['message'] = 'Appointment booked successfully.';
    } else {
        $response['message'] = $result['message'];
    }

} catch (Exception $e) {
    error_log("Booking Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
