<?php

/**
 * Notifications Action
 */

use Mindtrack\Server\Db\Notifications;
use Mindtrack\Lib\Notify;

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

try {

    // Code here...

} catch (Exception $e) {
    error_log("Notifications Action Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred: ' . $e->getMessage();
}

echo json_encode($response);
exit;
