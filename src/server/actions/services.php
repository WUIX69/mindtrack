<?php
/**
 * List Services Action
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Services;

try {
    $result = Services::all();
    $response = array_merge($response, $result);
} catch (Exception $e) {
    error_log("List Services Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
