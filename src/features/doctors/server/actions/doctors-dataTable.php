<?php

/**
 * Validates and processes the cleanup of the DataTables request.
 * 
 * This file is responsible for handling the server-side processing of the DataTables
 * library. It fetches the data from the database, applies filtering and sorting,
 * and returns the data in the format expected by the DataTables library.
 * 
 * @package Mindtrack\Features\Doctors\Server\Actions
 */

require_once dirname(__DIR__, 5) . '/src/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;
use Mindtrack\Features\Doctors\Server\Db\Doctors;


// Get DB Connection
$conn = Base::conn();
/**
 * Build the base query.
 * We use a subquery approach to allow complex joins and aggregations while keeping
 * the main DataTables logic clean.
 */
$format_table = "
    SELECT 
        u.uuid,
        CONCAT(u.firstname, ' ', u.lastname) AS doctor_name,
        u.email,
        u.phone,
        u.status,
        s.name AS specialty,
        di.availability,
        (SELECT COUNT(DISTINCT patient_uuid) FROM appointments WHERE doctor_uuid = u.uuid AND status IN ('confirmed', 'completed')) as patient_count,
        u.created_at
    FROM users u
    JOIN user_doctor_info di ON u.uuid = di.user_uuid
    LEFT JOIN specializations s ON di.specialization_id = s.id
    WHERE u.role = 'doctor'
";

// Use the subquery as the table source
$table = "($format_table) as derived_table";
$primaryKey = 'uuid';

// Define column mappings
$columns = array(
    ['db' => 'doctor_name', 'dt' => 'doctor_name'],
    ['db' => 'specialty', 'dt' => 'specialty'],
    ['db' => 'email', 'dt' => 'email'],
    ['db' => 'phone', 'dt' => 'phone'],
    ['db' => 'patient_count', 'dt' => 'patients'],
    ['db' => 'availability', 'dt' => 'availability'],
    ['db' => 'status', 'dt' => 'status'],
    ['db' => 'uuid', 'dt' => 'uuid'], // For actions
    ['db' => null, 'dt' => 'actions'], // Placeholder for client-side actions
    ['db' => 'created_at', 'dt' => 'created_at'] // Invisible column for sorting
);

// Apply Filters
$whereResult = null;
$whereAll = null;

// Specialty Filter
if (!empty($_GET['filter_specialty'])) {
    $specialty = addslashes($_GET['filter_specialty']);
    $whereResult = $whereResult ? "$whereResult AND specialty LIKE '%$specialty%'" : "specialty LIKE '%$specialty%'";
}

// Status Filter
if (!empty($_GET['filter_status'])) {
    $status = addslashes($_GET['filter_status']);
    $whereResult = $whereResult ? "$whereResult AND status = '$status'" : "status = '$status'";
}

// Get Data
$response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);
$response['counts'] = [
    'status' => Doctors::countWhereStatus($_GET),
    'specialty' => Doctors::countWhereSpecialty()
];

echo json_encode($response);
exit;
