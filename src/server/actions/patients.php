<?php
/**
 * Patients Action
 * 
 * Returns a JSON list of all active patients OR a single patient if UUID is provided.
 * Used for admin appointment creation dropdown and review summary.
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
use Mindtrack\Features\Patients\Server\Db\Patients;

try {
    $uuid = $_GET['uuid'] ?? null;
    $action = $_GET['action'] ?? null;

    if ($action == 'getPatientDetails' && $uuid) {
        // Fetch single patient with full details
        $result = Patients::single($uuid);
    } else if ($uuid) {
        // Fetch single patient quick details
        $result = Users::singleWherePatient($uuid);
    } else {
        // Fetch all patients (default)
        $result = Users::allWherePatients();
    }

    $response = array_merge($response, $result);

} catch (Exception $e) {
    error_log("Patients Action Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred: ' . $e->getMessage();
}

echo json_encode($response);
exit;
