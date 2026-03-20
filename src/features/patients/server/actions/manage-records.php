<?php
/**
 * manage-records.php
 * Handles View/Edit operations for Patient Records by Doctors.
 */

declare(strict_types=1);

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Features\Patients\Server\Db\Patients;
use Mindtrack\Lib\SessionManager;

// apiHeaders() is usually called in app.php but let's be explicit if needed or trust core/app.php
if (!function_exists('apiHeaders')) {
    function apiHeaders() {
        header('Content-Type: application/json');
    }
}
apiHeaders();

// Handle unexpected errors gracefully
try {
    // Security: Ensure Doctor Role
    if (!$session->get('uuid') || $session->get('role') !== 'doctor') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
        exit;
    }

    $currentDoctorUuid = $session->get('uuid');
    $action = $_GET['action'] ?? null;
    $patientUuid = $_GET['patient_uuid'] ?? $_POST['patient_uuid'] ?? null;

    if (!$patientUuid) {
        echo json_encode(['success' => false, 'message' => 'Patient UUID is required.']);
        exit;
    }

    switch ($action) {
        case 'getPatientRecords':
            $result = Patients::singleForDoctor($patientUuid, $currentDoctorUuid);
            echo json_encode($result);
            break;

        case 'updateMedicalHistory':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
                exit;
            }

            // Construct medical history array from POST
            $medicalHistory = [
                'conditions' => $_POST['conditions'] ?? '',
                'allergies' => $_POST['allergies'] ?? '',
                'alerts' => $_POST['alerts'] ?? []
            ];

            $result = Patients::updateMedicalHistory($patientUuid, $currentDoctorUuid, $medicalHistory);
            echo json_encode($result);
            break;

        case 'getSessionHistory':
            $result = Patients::getSessionHistory($patientUuid, $currentDoctorUuid);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            break;
    }

} catch (Throwable $e) {
    error_log("API Error (manage-records.php): " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
exit;
