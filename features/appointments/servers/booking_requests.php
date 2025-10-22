<?php
require_once __DIR__ . '/../../../core/app.php';

apiHeaders();

use MindTrack\Models\BookingRequests;
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
    error_log('Booking Requests API Error: ' . $e->getMessage());
    $response['message'] = 'An error occurred. Please try again later.';
    echo json_encode($response);
}

exit;

/**
 * Handle GET requests - Fetch booking requests
 */
function handleGet($user_uuid, $user_role)
{
    global $response;

    $action = $_GET['action'] ?? 'list';
    $uuid = $_GET['uuid'] ?? null;
    $status = $_GET['status'] ?? null;

    switch ($action) {
        case 'single':
            if (!$uuid) {
                $response['message'] = 'Booking request UUID is required';
                echo json_encode($response);
                return;
            }

            $result = BookingRequests::single($uuid);
            echo json_encode($result);
            break;

        case 'list':
            // Admins can see all booking requests
            if ($user_role === 'admin') {
                if ($status) {
                    $result = BookingRequests::allWhereStatus($status);
                } else {
                    $result = BookingRequests::all();
                }
            }
            // Patients can see their own booking requests
            elseif ($user_role === 'patient') {
                $result = BookingRequests::allWhereUser($user_uuid);
            }
            // Doctors can see all (for reference)
            elseif ($user_role === 'doctor') {
                $result = BookingRequests::all();
            } else {
                $response['message'] = 'Unauthorized access';
                echo json_encode($response);
                return;
            }

            echo json_encode($result);
            break;

        case 'by_status':
            if (!$status) {
                $response['message'] = 'Status is required';
                echo json_encode($response);
                return;
            }

            $result = BookingRequests::allWhereStatus($status);
            echo json_encode($result);
            break;

        default:
            $response['message'] = 'Invalid action';
            echo json_encode($response);
            break;
    }
}

/**
 * Handle POST requests - Create booking request
 */
function handlePost($user_uuid, $user_role)
{
    global $response;

    // Get user data if logged in
    $userData = null;
    if ($user_uuid) {
        $userResult = Users::single($user_uuid);
        if ($userResult['success']) {
            $userData = $userResult['data'];
        }
    }

    // Get and validate input
    $first_name = trim($_POST['first_name'] ?? ($userData['first_name'] ?? ''));
    $last_name = trim($_POST['last_name'] ?? ($userData['last_name'] ?? ''));
    $email = trim($_POST['email'] ?? ($userData['email'] ?? ''));
    $birthdate = trim($_POST['birthdate'] ?? '');
    $service_type = trim($_POST['service_type'] ?? '');
    $booking_date = trim($_POST['booking_date'] ?? '');
    $booking_time = trim($_POST['booking_time'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($birthdate)) {
        $response['message'] = 'Name, email, and birthdate are required.';
        echo json_encode($response);
        return;
    }

    if (empty($service_type) || empty($booking_date) || empty($booking_time)) {
        $response['message'] = 'Service type, date, and time are required.';
        echo json_encode($response);
        return;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format.';
        echo json_encode($response);
        return;
    }

    // Get patient custom ID if user is logged in as patient
    $patient_custom_id = null;
    if ($user_role === 'patient' && $userData) {
        $patientAdds = Users::getPatientAdds($user_uuid);
        $patient_custom_id = $patientAdds['patient_custom_id'] ?? null;
    }

    // Prepare booking request data
    $bookingData = [
        'uuid' => generateUUID(),
        'user_uuid' => $user_uuid,
        'patient_custom_id' => $patient_custom_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'service_type' => $service_type,
        'birthdate' => $birthdate,
        'booking_date' => $booking_date,
        'booking_time' => $booking_time,
        'status' => 'pending',
        'booking_code' => BookingRequests::generateBookingCode(),
        'notes' => $notes ?: null
    ];

    // Store booking request
    $result = BookingRequests::store($bookingData);
    echo json_encode($result);
}

/**
 * Handle PUT requests - Update booking request
 */
function handlePut($user_uuid, $user_role)
{
    global $response;

    // Only admins can update booking requests (approve/reject)
    if ($user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only admins can update booking requests.';
        echo json_encode($response);
        return;
    }

    // Parse PUT data
    parse_str(file_get_contents("php://input"), $put_data);

    $uuid = $put_data['uuid'] ?? '';
    $status = $put_data['status'] ?? '';

    if (empty($uuid) || empty($status)) {
        $response['message'] = 'UUID and status are required';
        echo json_encode($response);
        return;
    }

    // Validate status
    $validStatuses = ['pending', 'approved', 'rejected', 'cancelled'];
    if (!in_array($status, $validStatuses)) {
        $response['message'] = 'Invalid status';
        echo json_encode($response);
        return;
    }

    $result = BookingRequests::updateStatus($uuid, $status);
    echo json_encode($result);
}

/**
 * Handle DELETE requests - Delete booking request
 */
function handleDelete($user_uuid, $user_role)
{
    global $response;

    // Only admins and the request owner can delete
    parse_str(file_get_contents("php://input"), $delete_data);
    $uuid = $delete_data['uuid'] ?? '';

    if (empty($uuid)) {
        $response['message'] = 'Booking request UUID is required';
        echo json_encode($response);
        return;
    }

    // Check ownership if not admin
    if ($user_role !== 'admin') {
        $bookingResult = BookingRequests::single($uuid);
        if (!$bookingResult['success'] || $bookingResult['data']['user_uuid'] !== $user_uuid) {
            $response['message'] = 'Unauthorized. You can only delete your own booking requests.';
            echo json_encode($response);
            return;
        }
    }

    $result = BookingRequests::delete($uuid);
    echo json_encode($result);
}

