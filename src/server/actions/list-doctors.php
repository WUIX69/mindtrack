<?php
/**
 * List Doctors Action
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;

try {
    $result = Users::allWhereDoctors();

    if ($result['success']) {
        $response['success'] = true;
        $response['data'] = $result['data'];
        $response['message'] = $result['message'];
    } else {
        $response['message'] = $result['message'];
    }
} catch (Exception $e) {
    error_log("List Doctors Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
