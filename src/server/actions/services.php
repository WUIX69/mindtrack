<?php
/**
 * List Services Action
 */

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Services;

global $response;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? 'all';

        if ($action === 'single') {
            $uuid = $_GET['uuid'] ?? null;
            if ($uuid) {
                $result = Services::single($uuid);
                $response = array_merge($response, $result);
            } else {
                $response['message'] = 'Service UUID is required.';
            }
        } else {
            $result = Services::all();
            $response = array_merge($response, $result);
        }
    }
} catch (Exception $e) {
    error_log("List Services Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
