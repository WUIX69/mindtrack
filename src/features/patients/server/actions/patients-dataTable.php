<?php

/**
 * Validates and processes the DataTables request for Patients.
 */

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;

// Get DB Connection
$conn = Base::conn();

/**
 * Build the base query.
 * Joins users with patient info and subqueries for stats.
 */
$format_table = "
    SELECT 
        u.uuid,
        u.firstname,
        u.lastname,
        u.email,
        u.phone,
        u.status,
        pi.medical_history,
        (SELECT MAX(sched_date) FROM appointments WHERE patient_uuid = u.uuid AND status IN ('confirmed', 'completed')) as last_appt_date,
        (SELECT s.name FROM appointments a JOIN services s ON a.service_uuid = s.uuid WHERE a.patient_uuid = u.uuid AND a.status IN ('confirmed', 'completed') ORDER BY a.sched_date DESC, a.sched_time DESC LIMIT 1) as last_service_name,
        (SELECT COUNT(*) FROM appointments WHERE patient_uuid = u.uuid AND status = 'completed') as total_sessions
    FROM users u
    LEFT JOIN user_patient_info pi ON u.uuid = pi.user_uuid
    WHERE u.role = 'patient'
";

// Use the subquery as the table source
$table = "($format_table) as derived_table";
$primaryKey = 'uuid';

// Define column mappings
$columns = array(
    ['db' => 'firstname', 'dt' => 'firstname'],
    ['db' => 'lastname', 'dt' => 'lastname'],
    ['db' => 'email', 'dt' => 'email'],
    ['db' => 'phone', 'dt' => 'phone'],
    ['db' => 'status', 'dt' => 'status'],
    ['db' => 'medical_history', 'dt' => 'medical_history'],
    ['db' => 'last_appt_date', 'dt' => 'last_appt_date'],
    ['db' => 'last_service_name', 'dt' => 'last_service_name'],
    ['db' => 'total_sessions', 'dt' => 'total_sessions'],
    ['db' => 'uuid', 'dt' => 'uuid'], // For actions
    ['db' => null, 'dt' => 'actions'], // Placeholder for client-side actions
);

// Apply Filters (Status)
$whereResult = null;
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status = $_GET['status'];
    $whereResult = "status = '$status'";
}

$whereAll = null;

// Get Data
$response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);

// Stats logic can be added here if needed, currently reusing the DataTables response format.
// Re-format medical_history for easier consumption if needed, but DataTables just sends it as is.

echo json_encode($response);
exit;
