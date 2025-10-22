<?php
require_once __DIR__ . '/../../../core/app.php';

apiHeaders();

use MindTrack\Models\Users;

try {
    // Check if user is logged in
    if (!isset($_SESSION['logged_in'])) {
        $response['message'] = 'Unauthorized. Please login.';
        echo json_encode($response);
        exit;
    }

    $user_role = $_SESSION['role'] ?? null;
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            handleGet($user_role);
            break;

        case 'POST':
            handlePost($user_role);
            break;

        case 'PUT':
            handlePut($user_role);
            break;

        case 'DELETE':
            handleDelete($user_role);
            break;

        default:
            $response['message'] = 'Method not allowed';
            echo json_encode($response);
            break;
    }

} catch (Exception $e) {
    error_log('Users API Error: ' . $e->getMessage());
    $response['message'] = 'An error occurred. Please try again later.';
    echo json_encode($response);
}

exit;

/**
 * Handle GET requests
 */
function handleGet($user_role)
{
    global $response, $conn;

    $action = $_GET['action'] ?? 'list';
    $uuid = $_GET['uuid'] ?? null;

    switch ($action) {
        case 'single':
            if (!$uuid) {
                $response['message'] = 'User UUID is required';
                echo json_encode($response);
                return;
            }

            $result = Users::single($uuid);
            echo json_encode($result);
            break;

        case 'list':
            $result = Users::all();
            echo json_encode($result);
            break;

        case 'patients':
            // Get all patients with their patient-specific data
            try {
                $stmt = $conn->prepare('
                    SELECT 
                        u.uuid,
                        u.first_name,
                        u.last_name,
                        u.email,
                        u.phone,
                        pa.patient_custom_id,
                        pa.birthdate,
                        CONCAT(u.first_name, " ", u.last_name) as full_name
                    FROM users u
                    INNER JOIN users_patient_adds pa ON u.uuid = pa.user_uuid
                    WHERE u.role = "patient" AND u.status = "active"
                    ORDER BY u.first_name, u.last_name
                ');
                $stmt->execute();
                $patients = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

                $response = [
                    'success' => true,
                    'message' => 'Patients fetched successfully',
                    'data' => $patients
                ];
                echo json_encode($response);
            } catch (PDOException $e) {
                error_log("SQL Error: " . $e->getMessage());
                $response = [
                    'success' => false,
                    'message' => 'Failed to fetch patients: ' . $e->getMessage(),
                ];
                echo json_encode($response);
            }
            break;

        case 'doctors':
            // Get all doctors with their doctor-specific data
            try {
                $stmt = $conn->prepare('
                    SELECT 
                        u.uuid,
                        u.first_name,
                        u.last_name,
                        u.email,
                        u.phone,
                        da.doctor_custom_id,
                        da.specialization,
                        da.license_number,
                        CONCAT(u.first_name, " ", u.last_name) as full_name
                    FROM users u
                    INNER JOIN users_doctor_adds da ON u.uuid = da.user_uuid
                    WHERE u.role = "doctor" AND u.status = "active"
                    ORDER BY u.first_name, u.last_name
                ');
                $stmt->execute();
                $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

                $response = [
                    'success' => true,
                    'message' => 'Doctors fetched successfully',
                    'data' => $doctors
                ];
                echo json_encode($response);
            } catch (PDOException $e) {
                error_log("SQL Error: " . $e->getMessage());
                $response = [
                    'success' => false,
                    'message' => 'Failed to fetch doctors: ' . $e->getMessage(),
                ];
                echo json_encode($response);
            }
            break;

        default:
            $response['message'] = 'Invalid action';
            echo json_encode($response);
            break;
    }
}

/**
 * Handle POST requests
 */
function handlePost($user_role)
{
    global $response;

    // Only admins can create users
    if ($user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only admins can create users.';
        echo json_encode($response);
        return;
    }

    $action = $_POST['action'] ?? 'store';

    $data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'username' => trim($_POST['username'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'role' => $_POST['role'] ?? 'patient',
        'status' => $_POST['status'] ?? 'active',
    ];

    if ($action === 'store') {
        // Validation
        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['username']) || empty($data['password'])) {
            $response['message'] = 'Required fields are missing';
            echo json_encode($response);
            return;
        }

        $data['uuid'] = generateUUID();
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $result = Users::store($data);
        echo json_encode($result);
    }
}

/**
 * Handle PUT requests
 */
function handlePut($user_role)
{
    global $response;

    // Only admins can update users
    if ($user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only admins can update users.';
        echo json_encode($response);
        return;
    }

    parse_str(file_get_contents("php://input"), $put_data);

    $data = [
        'uuid' => $put_data['uuid'] ?? '',
        'first_name' => trim($put_data['first_name'] ?? ''),
        'last_name' => trim($put_data['last_name'] ?? ''),
        'email' => trim($put_data['email'] ?? ''),
        'phone' => trim($put_data['phone'] ?? ''),
        'status' => $put_data['status'] ?? 'active',
    ];

    if (empty($data['uuid'])) {
        $response['message'] = 'User UUID is required';
        echo json_encode($response);
        return;
    }

    $result = Users::update($data);
    echo json_encode($result);
}

/**
 * Handle DELETE requests
 */
function handleDelete($user_role)
{
    global $response;

    // Only admins can delete users
    if ($user_role !== 'admin') {
        $response['message'] = 'Unauthorized. Only admins can delete users.';
        echo json_encode($response);
        return;
    }

    parse_str(file_get_contents("php://input"), $delete_data);
    $uuid = $delete_data['uuid'] ?? '';

    if (empty($uuid)) {
        $response['message'] = 'User UUID is required';
        echo json_encode($response);
        return;
    }

    $result = Users::delete($uuid);
    echo json_encode($result);
}
