<?php
require_once __DIR__ . '/../../../core/app.php';
require_once __DIR__ . '/../../../models/labResults.php';

apiHeaders();

use MindTrack\Models\LabResults;

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
    error_log('Lab Results API Error: ' . $e->getMessage());
    $response['message'] = 'An error occurred. Please try again later.';
    echo json_encode($response);
}

exit;

/**
 * Handle GET requests - Fetch lab results
 */
function handleGet($user_uuid, $user_role)
{
    global $response;

    $action = $_GET['action'] ?? 'list';
    $uuid = $_GET['uuid'] ?? null;

    switch ($action) {
        case 'single':
            if (!$uuid) {
                $response['message'] = 'Lab result UUID is required';
                echo json_encode($response);
                return;
            }

            $result = LabResults::single($uuid);

            // Check access rights
            if ($result['success'] && !empty($result['data'])) {
                if ($user_role === 'patient' && $result['data']['patient_uuid'] !== $user_uuid) {
                    $response['message'] = 'Unauthorized access';
                    echo json_encode($response);
                    return;
                }
            }

            echo json_encode($result);
            break;

        case 'list':
            // Admins can see all lab results
            if ($user_role === 'admin') {
                $result = LabResults::all();
            }
            // Doctors can see their lab results
            elseif ($user_role === 'doctor') {
                $result = LabResults::allWhereDoctor($user_uuid);
            }
            // Patients can see their lab results
            elseif ($user_role === 'patient') {
                $result = LabResults::allWherePatient($user_uuid);
            } else {
                $response['message'] = 'Unauthorized access';
                echo json_encode($response);
                return;
            }

            echo json_encode($result);
            break;

        default:
            $response['message'] = 'Invalid action';
            echo json_encode($response);
            break;
    }
}

/**
 * Handle POST requests - Create lab result
 */
function handlePost($user_uuid, $user_role)
{
    global $response;

    // Only doctors and admins can create lab results
    if ($user_role !== 'doctor' && $user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only doctors and admins can create lab results.';
        echo json_encode($response);
        return;
    }

    // Get and validate input
    $patient_uuid = trim($_POST['patient_uuid'] ?? '');
    $test_name = trim($_POST['test_name'] ?? '');
    $test_type = trim($_POST['test_type'] ?? '');
    $test_date = trim($_POST['test_date'] ?? '');
    $result_summary = trim($_POST['result_summary'] ?? '');
    $detailed_results = trim($_POST['detailed_results'] ?? '');
    $findings = trim($_POST['findings'] ?? '');
    $recommendations = trim($_POST['recommendations'] ?? '');
    $reference_values = trim($_POST['reference_values'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $appointment_uuid = trim($_POST['appointment_uuid'] ?? '');

    // Validation
    if (empty($patient_uuid) || empty($test_name) || empty($test_type) || empty($test_date)) {
        $response['message'] = 'Patient, test name, test type, and test date are required.';
        echo json_encode($response);
        return;
    }

    // Prepare lab result data
    $labResultData = [
        'uuid' => generateUUID(),
        'patient_uuid' => $patient_uuid,
        'doctor_uuid' => $user_role === 'doctor' ? $user_uuid : null,
        'appointment_uuid' => $appointment_uuid ?: null,
        'test_name' => $test_name,
        'test_type' => $test_type,
        'test_date' => $test_date,
        'result_status' => 'completed',
        'result_summary' => $result_summary ?: null,
        'detailed_results' => $detailed_results ?: null,
        'findings' => $findings ?: null,
        'recommendations' => $recommendations ?: null,
        'reference_values' => $reference_values ?: null,
        'notes' => $notes ?: null
    ];

    // Store lab result
    $result = LabResults::store($labResultData);
    echo json_encode($result);
}

/**
 * Handle PUT requests - Update lab result
 */
function handlePut($user_uuid, $user_role)
{
    global $response;

    // Only doctors and admins can update lab results
    if ($user_role !== 'doctor' && $user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only doctors and admins can update lab results.';
        echo json_encode($response);
        return;
    }

    // Parse PUT data
    parse_str(file_get_contents("php://input"), $put_data);

    $action = $put_data['action'] ?? 'update';
    $uuid = $put_data['uuid'] ?? '';

    if (empty($uuid)) {
        $response['message'] = 'Lab result UUID is required';
        echo json_encode($response);
        return;
    }

    switch ($action) {
        case 'update':
            $labResultData = [
                'uuid' => $uuid,
                'test_name' => trim($put_data['test_name'] ?? ''),
                'test_type' => trim($put_data['test_type'] ?? ''),
                'test_date' => trim($put_data['test_date'] ?? ''),
                'result_status' => trim($put_data['result_status'] ?? 'completed'),
                'result_summary' => trim($put_data['result_summary'] ?? ''),
                'detailed_results' => trim($put_data['detailed_results'] ?? ''),
                'findings' => trim($put_data['findings'] ?? ''),
                'recommendations' => trim($put_data['recommendations'] ?? ''),
                'reference_values' => trim($put_data['reference_values'] ?? ''),
                'notes' => trim($put_data['notes'] ?? '')
            ];

            $result = LabResults::update($labResultData);
            echo json_encode($result);
            break;

        case 'status':
            $status = trim($put_data['status'] ?? '');

            if (empty($status)) {
                $response['message'] = 'Status is required';
                echo json_encode($response);
                return;
            }

            $result = LabResults::updateStatus($uuid, $status);
            echo json_encode($result);
            break;

        default:
            $response['message'] = 'Invalid action';
            echo json_encode($response);
            break;
    }
}

/**
 * Handle DELETE requests - Delete lab result
 */
function handleDelete($user_uuid, $user_role)
{
    global $response;

    // Only admins can delete lab results
    if ($user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only admins can delete lab results.';
        echo json_encode($response);
        return;
    }

    // Parse DELETE data
    parse_str(file_get_contents("php://input"), $delete_data);
    $uuid = $delete_data['uuid'] ?? '';

    if (empty($uuid)) {
        $response['message'] = 'Lab result UUID is required';
        echo json_encode($response);
        return;
    }

    $result = LabResults::delete($uuid);
    echo json_encode($result);
}

