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
    $user_uuid = $session->get('uuid');
    $user_type = $session->get('role');
    $existing_uuid = $input['appointment_uuid'] ?? null;

    if (!$user_uuid) {
        $response['message'] = 'User session not found. Please log in again.';
        echo json_encode($response);
        exit;
    }

    // Determine target patient
    $target_patient_uuid = $user_uuid;
    if ($user_type === 'admin') {
        if (isset($input['patient_uuid']) && !empty($input['patient_uuid'])) {
            $target_patient_uuid = $input['patient_uuid'];
        } elseif (!$existing_uuid) {
            $response['message'] = 'Patient is required for admin booking.';
            echo json_encode($response);
            exit;
        }
    }

    // Determine status
    $status = 'pending';
    if ($existing_uuid && ($input['is_reschedule'] ?? false)) {
        $status = 'rescheduled';
    }
    // Admin actions are confirmed by default (unless specifically set otherwise, but here we assume confirmed)
    if ($user_type === 'admin') {
        $status = 'confirmed';
    }

    // Prepare data for storage
    $data = [
        'patient_uuid' => $target_patient_uuid,
        'doctor_uuid' => $validData['doctor_uuid'],
        'service_uuid' => $validData['service_uuid'],
        'sched_date' => $validData['sched_date'],
        'sched_time' => $validData['sched_time'],
        'status' => $status,
        'notes' => $validData['notes'] ?: null
    ];

    if ($existing_uuid) {
        // Ownership check for non-admins
        if ($user_type !== 'admin') {
            // Check if appointment belongs to patient
            $check = appointments::allWherePatient($user_uuid);
            $isOwner = false;
            if ($check['success']) {
                foreach ($check['data'] as $appt) {
                    if ($appt['uuid'] === $existing_uuid) {
                        $isOwner = true;
                        break;
                    }
                }
            }
            if (!$isOwner) {
                $response['message'] = 'Unauthorized modification.';
                echo json_encode($response);
                exit;
            }
        }
        $result = appointments::update($existing_uuid, $data);
    } else {
        $data['uuid'] = uuid();
        $result = appointments::store($data);
    }

    if ($result['success']) {
        $response['success'] = true;
        $response['message'] = $existing_uuid ? 'Appointment updated successfully.' : 'Appointment booked successfully.';
    } else {
        $response['message'] = $result['message'];
    }

} catch (Exception $e) {
    error_log("Booking Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
