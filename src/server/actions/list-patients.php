<?php
/**
 * List Patients Action
 * 
 * Returns a JSON list of all active patients.
 * Used for admin appointment creation dropdown.
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;

try {

    $result = Users::allWherePatients();
    $response = array_merge($response, $result);

} catch (Exception $e) {
    error_log("List Patients Action Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred: ' . $e->getMessage();
}

echo json_encode($response);
exit;
