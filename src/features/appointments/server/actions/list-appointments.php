<?php
/**
 * List Appointments Action
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;

try {
    $patient_uuid = $session->get('uuid');
    if (!$patient_uuid) {
        $response['message'] = 'Unauthorized.';
        echo json_encode($response);
        exit;
    }

    $result = appointments::allWherePatient($patient_uuid);
    $response = array_merge($response, $result);
} catch (Exception $e) {
    error_log("List Appointments Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
