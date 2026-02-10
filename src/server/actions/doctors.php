<?php
/**
 * List Doctors Action
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;

try {
    $result = Users::allWhereDoctors();
    $response = array_merge($response, $result);
} catch (Exception $e) {
    error_log("List Doctors Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
