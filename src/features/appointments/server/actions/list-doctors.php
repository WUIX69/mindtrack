<?php
/**
 * List Doctors Action
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

try {
    $db = \Mindtrack\Server\Db\Base::conn();
    $stmt = $db->query("
        SELECT u.uuid, u.firstname, u.lastname, di.specialization 
        FROM users u 
        JOIN user_doctor_info di ON u.uuid = di.user_uuid 
        WHERE u.role = 'doctor' AND u.status = 'active'
    ");
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $doctors;
    $response['message'] = 'Doctors fetched successfully.';
} catch (Exception $e) {
    error_log("List Doctors Error: " . $e->getMessage());
    $response['message'] = 'An internal error occurred.';
}

echo json_encode($response);
exit;
