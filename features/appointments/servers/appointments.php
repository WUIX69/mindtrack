<?php
require_once __DIR__ . '/../../../core/app.php';

apiHeaders();

use MindTrack\Models\Appointments;
use MindTrack\Models\Users;

try {
    // Check if user is logged in
    if (!isset($_SESSION['logged_in'])) {
        $response['message'] = 'Unauthorized. Please login.';
        echo json_encode($response);
        exit;
    }

    $user_uuid = $_SESSION['user_uuid'] ?? null;
    $user_role = $_SESSION['role'] ?? null;

    // Handle different HTTP methods
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            handleGet($user_uuid, $user_role);
            break;

        case 'POST':
            handlePost($user_uuid, $user_role);
            break;

        case 'PUT':
            handlePut($user_uuid, $user_role);
            break;

        case 'DELETE':
            handleDelete($user_uuid, $user_role);
            break;

        default:
            $response['message'] = 'Method not allowed';
            echo json_encode($response);
            break;
    }

} catch (Exception $e) {
    error_log('Appointments API Error: ' . $e->getMessage());
    $response['message'] = 'An error occurred. Please try again later.';
    echo json_encode($response);
}

exit;

/**
 * Handle GET requests - Fetch appointments
 */
function handleGet($user_uuid, $user_role)
{
    global $response;

    $action = $_GET['action'] ?? 'list';
    $uuid = $_GET['uuid'] ?? null;
    $doctor_uuid = $_GET['doctor_uuid'] ?? null;
    $patient_uuid = $_GET['patient_uuid'] ?? null;

    switch ($action) {
        case 'single':
            if (!$uuid) {
                $response['message'] = 'Appointment UUID is required';
                echo json_encode($response);
                return;
            }

            $result = Appointments::single($uuid);
            echo json_encode($result);
            break;

        case 'list':
            // Admins can see all appointments
            if ($user_role === 'admin') {
                $result = Appointments::all();
            }
            // Doctors can see their appointments
            elseif ($user_role === 'doctor') {
                $result = Appointments::allWhereDoctor($user_uuid);
            }
            // Patients can see their appointments
            elseif ($user_role === 'patient') {
                $result = Appointments::allWherePatient($user_uuid);
            } else {
                $response['message'] = 'Unauthorized access';
                echo json_encode($response);
                return;
            }

            echo json_encode($result);
            break;

        case 'by_doctor':
            if (!$doctor_uuid) {
                $response['message'] = 'Doctor UUID is required';
                echo json_encode($response);
                return;
            }

            $result = Appointments::allWhereDoctor($doctor_uuid);
            echo json_encode($result);
            break;

        case 'by_patient':
            if (!$patient_uuid) {
                $response['message'] = 'Patient UUID is required';
                echo json_encode($response);
                return;
            }

            $result = Appointments::allWherePatient($patient_uuid);
            echo json_encode($result);
            break;

        default:
            $response['message'] = 'Invalid action';
            echo json_encode($response);
            break;
    }
}

/**
 * Handle POST requests - Create appointment
 */
function handlePost($user_uuid, $user_role)
{
    global $response;

    // Only doctors and admins can create appointments
    if ($user_role !== 'doctor' && $user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only doctors and admins can create appointments.';
        echo json_encode($response);
        return;
    }

    // Get and validate input
    $patient_uuid = trim($_POST['patient_uuid'] ?? '');
    $doctor_uuid = trim($_POST['doctor_uuid'] ?? '');
    $appointment_date = trim($_POST['appointment_date'] ?? '');
    $appointment_time = trim($_POST['appointment_time'] ?? '');
    $service_type = trim($_POST['service_type'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    // Validation
    if (empty($patient_uuid) || empty($appointment_date) || empty($appointment_time) || empty($service_type)) {
        $response['message'] = 'Patient, date, time, and service type are required.';
        echo json_encode($response);
        return;
    }

    // If doctor is creating, use their UUID if not specified
    if ($user_role === 'doctor' && empty($doctor_uuid)) {
        $doctor_uuid = $user_uuid;
    }

    // Prepare appointment data
    $appointmentData = [
        'uuid' => generateUUID(),
        'booking_uuid' => null,
        'patient_uuid' => $patient_uuid,
        'doctor_uuid' => $doctor_uuid ?: null,
        'appointment_date' => $appointment_date,
        'appointment_time' => $appointment_time,
        'service_type' => $service_type,
        'status' => 'scheduled',
        'booking_code' => Appointments::generateBookingCode(),
        'remarks' => $remarks ?: null
    ];

    // Store appointment
    $result = Appointments::store($appointmentData);
    echo json_encode($result);
}

/**
 * Handle PUT requests - Update appointment
 */
function handlePut($user_uuid, $user_role)
{
    global $response;

    // Only doctors and admins can update appointments
    if ($user_role !== 'doctor' && $user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only doctors and admins can update appointments.';
        echo json_encode($response);
        return;
    }

    // Parse PUT data
    parse_str(file_get_contents("php://input"), $put_data);

    $action = $put_data['action'] ?? 'update';
    $uuid = $put_data['uuid'] ?? '';

    if (empty($uuid)) {
        $response['message'] = 'Appointment UUID is required';
        echo json_encode($response);
        return;
    }

    switch ($action) {
        case 'update':
            $patient_uuid = trim($put_data['patient_uuid'] ?? '');
            $doctor_uuid = trim($put_data['doctor_uuid'] ?? '');
            $appointment_date = trim($put_data['appointment_date'] ?? '');
            $appointment_time = trim($put_data['appointment_time'] ?? '');
            $service_type = trim($put_data['service_type'] ?? '');
            $status = trim($put_data['status'] ?? 'scheduled');
            $remarks = trim($put_data['remarks'] ?? '');
            $prescription = trim($put_data['prescription'] ?? '');
            $diagnosis = trim($put_data['diagnosis'] ?? '');

            if (empty($patient_uuid) || empty($appointment_date) || empty($appointment_time) || empty($service_type)) {
                $response['message'] = 'Patient, date, time, and service type are required.';
                echo json_encode($response);
                return;
            }

            $appointmentData = [
                'uuid' => $uuid,
                'patient_uuid' => $patient_uuid,
                'doctor_uuid' => $doctor_uuid ?: null,
                'appointment_date' => $appointment_date,
                'appointment_time' => $appointment_time,
                'service_type' => $service_type,
                'status' => $status,
                'remarks' => $remarks ?: null,
                'prescription' => $prescription ?: null,
                'diagnosis' => $diagnosis ?: null
            ];

            $result = Appointments::update($appointmentData);
            echo json_encode($result);
            break;

        case 'status':
            $status = trim($put_data['status'] ?? '');

            if (empty($status)) {
                $response['message'] = 'Status is required';
                echo json_encode($response);
                return;
            }

            $result = Appointments::updateStatus($uuid, $status);
            echo json_encode($result);
            break;

        case 'medical_notes':
            $prescription = trim($put_data['prescription'] ?? '');
            $diagnosis = trim($put_data['diagnosis'] ?? '');

            $result = Appointments::addMedicalNotes($uuid, $prescription, $diagnosis);
            echo json_encode($result);
            break;

        default:
            $response['message'] = 'Invalid action';
            echo json_encode($response);
            break;
    }
}

/**
 * Handle DELETE requests - Delete appointment
 */
function handleDelete($user_uuid, $user_role)
{
    global $response;

    // Only doctors and admins can delete appointments
    if ($user_role !== 'doctor' && $user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only doctors and admins can delete appointments.';
        echo json_encode($response);
        return;
    }

    // Parse DELETE data
    parse_str(file_get_contents("php://input"), $delete_data);
    $uuid = $delete_data['uuid'] ?? '';

    if (empty($uuid)) {
        $response['message'] = 'Appointment UUID is required';
        echo json_encode($response);
        return;
    }

    $result = Appointments::delete($uuid);
    echo json_encode($result);
}

