<?php
/**
 * List Appointments Action
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\appointments;

try {
    $user_type = $session->get('role');
    $user_uuid = $session->get('uuid');

    if (!$user_uuid) {
        $response['message'] = 'Unauthorized.';
        echo json_encode($response);
        exit;
    }

    if ($user_type === 'admin') {
        $result = appointments::all();
    } else {
        $result = appointments::allWherePatient($user_uuid);
    }

    $response = array_merge($response, $result);
} catch (Exception $e) {
    error_log("List Appointments Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
