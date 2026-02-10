<?php
/**
 * List Doctors Action
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
use Mindtrack\Server\Db\Services;

try {
    $serviceUuid = $_GET['service_uuid'] ?? null;
    $specializationId = null;

    if ($serviceUuid) {
        $service = Services::single($serviceUuid)['data'] ?? [];
        $specializationId = $service['specialization_id'] ?? null;
    }

    $result = Users::allWhereDoctorsBySpecialization($specializationId);
    $response = array_merge($response, $result);
} catch (Exception $e) {
    error_log("List Doctors Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
