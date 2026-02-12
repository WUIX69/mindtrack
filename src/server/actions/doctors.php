<?php
/**
 * List Doctors Action
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
use Mindtrack\Server\Db\Services;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $serviceUuid = $_GET['service_uuid'] ?? null;

    if ($serviceUuid) {
        $specializationId = Services::single($serviceUuid)['data']['specialization_id'] ?? null;
        $result = Users::allWhereDoctorsSpecialization($specializationId);
    } else {
        $result = Users::allWhereDoctors();
    }

    $response = array_merge($response, $result);

} catch (Exception $e) {
    error_log("List Doctors Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
