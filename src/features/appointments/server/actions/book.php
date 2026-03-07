<?php
/**
 * Appointment Booking Action
 * Standardized with API headers and Schema validation.
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;
use Mindtrack\Features\Appointments\Schemas\Appointment;
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
    } elseif ($user_type === 'doctor' && $existing_uuid) {
        // Doctor reschedule: keep the original patient
        $appt = appointments::single($existing_uuid);
        if ($appt) {
            $target_patient_uuid = $appt['patient_uuid'];
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

    $result = null;
    if ($existing_uuid) {
        // Ownership check for non-admins
        if ($user_type !== 'admin') {
            // Check if appointment exists and belongs to user
            $appt = appointments::single($existing_uuid);

            if (!$appt) {
                $response['message'] = 'Appointment not found.';
                echo json_encode($response);
                exit;
            }

            $isAuthorized = false;

            if ($user_type === 'doctor') {
                // Doctor check: must be the assigned doctor
                if ($appt['doctor_uuid'] === $user_uuid) {
                    $isAuthorized = true;
                }
            } else {
                // Patient check: must be the patient
                /* 
                   Note: appointments::allWherePatients matches patient_uuid.
                   We check against the record found.
                */
                if ($appt['patient_uuid'] === $user_uuid) {
                    $isAuthorized = true;
                }
            }

            if (!$isAuthorized) {
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

    $response = array_merge($response, $result);

    // Send Notifications on Success
    if ($response['success'] ?? false) {
        // Format date and time for notification description
        $formattedDate = date('M j, Y', strtotime($data['sched_date']));
        $formattedTime = date('g:i A', strtotime($data['sched_time']));

        if (!$existing_uuid) {
            // New booking
            $notifyData = [
                'type' => 'new_appointment',
                'title' => 'New Appointment Scheduled',
                'description' => "An appointment is booked for $formattedDate at $formattedTime.",
                'icon' => 'calendar_month',
                'color' => 'blue'
            ];

            $notify = new Notify();

            // Notify admins
            $notify->send($user_uuid, $notifyData['type'], $notifyData, 'admin', 'all');
            // Notify assigned doctor (if not the one who booked)
            if ($data['doctor_uuid'] !== $user_uuid) {
                $notify->send($data['doctor_uuid'], $notifyData['type'], $notifyData);
            }
        } elseif ($existing_uuid && ($input['is_reschedule'] ?? false)) {
            // Reschedule
            $notifyData = [
                'type' => 'appointment_rescheduled',
                'title' => 'Appointment Rescheduled',
                'description' => "An appointment is rescheduled to $formattedDate at $formattedTime.",
                'icon' => 'event',
                'color' => 'orange'
            ];

            // Notify admins
            $notify->send($user_uuid, $notifyData['type'], $notifyData, 'admin', 'all');

            // Notify the other party
            if ($user_type === 'patient') {
                // Patient rescheduled -> Notify doctor
                $notify->send($data['doctor_uuid'], $notifyData['type'], $notifyData);
            } elseif ($user_type === 'doctor') {
                // Doctor rescheduled -> Notify patient
                $notify->send($data['patient_uuid'], $notifyData['type'], $notifyData);
            } else {
                // Admin rescheduled -> Notify both
                $notify->send($data['patient_uuid'], $notifyData['type'], $notifyData);
                $notify->send($data['doctor_uuid'], $notifyData['type'], $notifyData);
            }
        }
    }
} catch (Exception $e) {
    error_log("Booking Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
