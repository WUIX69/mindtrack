<?php

/**
 * Server-Side Processing (SSP) for Doctor's Patients DataTable
 * Filters patients by the currently logged-in doctor.
 */

// Start output buffering to capture any unwanted output
ob_start();

require_once dirname(__DIR__, 5) . '/src/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;

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
     * Build the base query.
     * Joins users with appointments to filter by doctor.
     * Uses subqueries for stats (Last Session, Next Session, Primary Service).
     */
    $format_table = "
        SELECT DISTINCT
            u.uuid,
            CONCAT(u.firstname, ' ', u.lastname) as name,
            u.email,
            u.phone,
            u.status,
            u.created_at,
            
            -- Last session date (with this doctor)
            (SELECT MAX(sched_date) FROM appointments 
             WHERE patient_uuid = u.uuid AND doctor_uuid = '$currentDoctorUuid' 
             AND status IN ('confirmed', 'completed')) as last_session,
             
            -- Next session date (with this doctor)
            (SELECT MIN(sched_date) FROM appointments
             WHERE patient_uuid = u.uuid AND doctor_uuid = '$currentDoctorUuid'
             AND status IN ('confirmed', 'pending') AND sched_date >= CURDATE()) as next_session,
             
            -- Primary service (most recent confirmed/completed appointment with this doctor)
            (SELECT s.name FROM appointments a 
             JOIN services s ON a.service_uuid = s.uuid
             WHERE a.patient_uuid = u.uuid AND a.doctor_uuid = '$currentDoctorUuid'
             AND a.status IN ('confirmed', 'completed')
             ORDER BY a.sched_date DESC, a.sched_time DESC LIMIT 1) as primary_service,
             
            -- Total sessions (completed with this doctor)
            (SELECT COUNT(*) FROM appointments
             WHERE patient_uuid = u.uuid AND doctor_uuid = '$currentDoctorUuid'
             AND status = 'completed') as total_sessions

        FROM users u
        INNER JOIN appointments apt ON u.uuid = apt.patient_uuid AND apt.doctor_uuid = '$currentDoctorUuid'
        WHERE u.role = 'patient'
    ";

    // Use the subquery as the table source
    $table = "($format_table) as derived_table";
    $primaryKey = 'uuid';

    // Define column mappings
    $columns = [
        ['db' => 'name', 'dt' => 'name'],
        ['db' => 'email', 'dt' => 'email'],
        ['db' => 'phone', 'dt' => 'phone'],
        ['db' => 'status', 'dt' => 'status'],
        ['db' => 'last_session', 'dt' => 'last_session'],
        ['db' => 'next_session', 'dt' => 'next_session'],
        ['db' => 'primary_service', 'dt' => 'primary_service'],
        ['db' => 'total_sessions', 'dt' => 'total_sessions'],
        ['db' => 'uuid', 'dt' => 'uuid'], // For actions/ID badge
        ['db' => 'created_at', 'dt' => 'created_at'], // For sorting
    ];

    $whereResult = null;
    $whereAll = null;

    $response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);

    // Clear buffer and output JSON
    ob_clean();
    echo json_encode($response);

} catch (Throwable $e) {
    error_log("DataTable Error (Doctor Patients): " . $e->getMessage());
    ob_clean();
    echo json_encode([
        'draw' => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => [],
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
exit;
