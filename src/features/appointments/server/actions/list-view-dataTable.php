<?php

/**
 * Server-Side Processing (SSP) for Schedule List View DataTable
 * Filters appointments by the currently logged-in doctor.
 */

// Start output buffering to capture any unwanted output (warnings, etc.)
ob_start();

require_once dirname(__DIR__, 5) . '/src/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;
use Mindtrack\Server\Db\appointments;

apiHeaders();

// Handle unexpected errors gracefully
try {
    // Security: Ensure Doctor Role
    if (!$session->get('uuid') || $session->get('role') !== 'doctor') {
        throw new Exception('Unauthorized access.');
    }

    $currentDoctorUuid = $session->get('uuid');
    $conn = Base::conn();

    /**
     * Subquery for DataTables
     */
    $format_table = "
        SELECT
            a.uuid,
            a.patient_uuid,
            a.status,
            a.sched_date,
            a.sched_time,
            CONCAT(a.sched_date, ' ', a.sched_time) as appointment_datetime,
            s.name AS service_name,
            s.duration,
            s.price,
            CONCAT(p.firstname, ' ', p.lastname) AS patient_name,
            p.email AS patient_email
        FROM appointments a
        LEFT JOIN users p ON a.patient_uuid = p.uuid
        LEFT JOIN services s ON a.service_uuid = s.uuid
        WHERE a.doctor_uuid = '$currentDoctorUuid'
    ";

    // Use the subquery as the table source
    $table = "($format_table) as derived_table";
    $primaryKey = 'uuid';

    $columns = [
        ['db' => 'uuid', 'dt' => 'id'],
        ['db' => 'patient_name', 'dt' => 'patient_name'],
        ['db' => 'patient_email', 'dt' => 'patient_email'],
        ['db' => 'patient_uuid', 'dt' => 'patient_id'],
        ['db' => 'service_name', 'dt' => 'service_name'],
        ['db' => 'status', 'dt' => 'status'],
        ['db' => 'sched_date', 'dt' => 'date'],
        ['db' => 'sched_time', 'dt' => 'time_start'],
        ['db' => 'appointment_datetime', 'dt' => 'appointment_datetime'],
        ['db' => 'duration', 'dt' => 'duration'],
        ['db' => 'price', 'dt' => 'price'],
    ];

    $whereResult = null;
    $whereAll = null;

    $response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);

    // Append Counts
    $response['counts'] = appointments::countWhereStatus(['doctor_uuid' => $currentDoctorUuid]);

    // Clear buffer and output JSON
    ob_clean();
    echo json_encode($response);

} catch (Throwable $e) {
    // Catch specific DataTables error or general exceptions
    error_log("DataTable Error: " . $e->getMessage());
    ob_clean(); // Clear buffer before outputting error JSON
    echo json_encode([
        'draw' => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => [],
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
exit;
