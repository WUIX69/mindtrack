<?php
/**
 * List Services Action
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Services;

try {
    $result = Services::all();
    if ($result['success']) {
        $response['success'] = true;
        $response['data'] = $result['data'];
        $response['message'] = 'Services fetched successfully.';
    } else {
        $response['message'] = $result['message'];
    }
} catch (Exception $e) {
    error_log("List Services Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
