<?php

/**
 * Server-Side Processing (SSP) for Appointment History DataTable
 * Filters appointments by the currently logged-in patient.
 */

ob_start();

require_once dirname(__DIR__, 5) . '/src/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;
use Mindtrack\Server\Db\Appointments;

apiHeaders();

try {
    // Security: Ensure Patient Role
    if (!$session->get('uuid') || $session->get('role') !== 'patient') {
        throw new Exception('Unauthorized access.');
    }

    $currentPatientUuid = $session->get('uuid');
    $conn = Base::conn();

    $format_table = "
         SELECT
            a.uuid,
            a.patient_uuid,
            a.doctor_uuid,
            a.service_uuid,
            a.sched_date,
            a.sched_time,
            a.status,
            a.notes,
            a.created_at,
            s.name AS service_name,
            s.duration AS service_duration,
            CONCAT(u.firstname, ' ', u.lastname) AS doctor_name,
            u.firstname AS doctor_firstname,
            u.lastname AS doctor_lastname
        FROM appointments a
        LEFT JOIN services s ON a.service_uuid = s.uuid
        LEFT JOIN users u ON a.doctor_uuid = u.uuid
        WHERE a.patient_uuid = '$currentPatientUuid'
    ";

    $table = "($format_table) as derived_table";
    $primaryKey = 'uuid';

    $columns = array(
        ['db' => 'sched_date', 'dt' => 'sched_date'],
        ['db' => 'service_name', 'dt' => 'service_name'],
        ['db' => 'doctor_name', 'dt' => 'doctor_name'],
        ['db' => 'status', 'dt' => 'status'],
        ['db' => 'uuid', 'dt' => 'uuid'],
        ['db' => 'sched_time', 'dt' => 'sched_time'],
        ['db' => 'doctor_firstname', 'dt' => 'doctor_firstname'],
        ['db' => 'doctor_lastname', 'dt' => 'doctor_lastname'],
        ['db' => 'doctor_uuid', 'dt' => 'doctor_uuid'],
        ['db' => 'service_uuid', 'dt' => 'service_uuid'],
        ['db' => 'patient_uuid', 'dt' => 'patient_uuid'],
        ['db' => 'service_duration', 'dt' => 'service_duration'],
        ['db' => 'notes', 'dt' => 'notes'],
        ['db' => 'created_at', 'dt' => 'created_at']
    );

    $whereResult = null;
    $whereAll = null;

    $response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);
    $response['counts'] = Appointments::countWhereStatus(['patient_uuid' => $currentPatientUuid]);

    ob_clean();
    echo json_encode($response);

} catch (Throwable $e) {
    error_log("DataTable Error: " . $e->getMessage());
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
