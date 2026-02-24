<?php

/**
 * Server-Side Processing (SSP) for Admin Notes DataTable
 * Returns all notes in the system.
 */

ob_start();

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;
use Mindtrack\Features\Notes\Server\Db\Notes;

apiHeaders();

try {
    // Security: Ensure Admin Role
    if (!$session->get('uuid') || $session->get('role') !== 'admin') {
        throw new Exception('Unauthorized access.');
    }

    $conn = Base::conn();

    $format_table = "
         SELECT
            cn.uuid,
            cn.patient_uuid,
            cn.doctor_uuid,
            cn.appointment_uuid,
            cn.subjective,
            cn.status,
            cn.created_at,
            cn.updated_at,
            a.sched_date,
            a.sched_time,
            s.name AS service_name,
            CONCAT(d.firstname, ' ', d.lastname) AS doctor_name,
            CONCAT(p.firstname, ' ', p.lastname) AS patient_name
        FROM clinical_notes cn
        LEFT JOIN appointments a ON cn.appointment_uuid = a.uuid
        LEFT JOIN services s ON a.service_uuid = s.uuid
        LEFT JOIN users d ON cn.doctor_uuid = d.uuid
        LEFT JOIN users p ON cn.patient_uuid = p.uuid
    ";

    $table = "($format_table) as derived_table";
    $primaryKey = 'uuid';

    $columns = array(
        ['db' => 'uuid', 'dt' => 'uuid'],
        ['db' => 'status', 'dt' => 'status'],
        ['db' => 'subjective', 'dt' => 'subjective'],
        ['db' => 'created_at', 'dt' => 'created_at'],
        ['db' => 'updated_at', 'dt' => 'updated_at'],
        ['db' => 'sched_date', 'dt' => 'sched_date'],
        ['db' => 'sched_time', 'dt' => 'sched_time'],
        ['db' => 'service_name', 'dt' => 'service_name'],
        ['db' => 'doctor_name', 'dt' => 'doctor_name'],
        ['db' => 'patient_name', 'dt' => 'patient_name'],
        ['db' => 'appointment_uuid', 'dt' => 'appointment_uuid'],
        ['db' => 'patient_uuid', 'dt' => 'patient_uuid'],
        ['db' => 'doctor_uuid', 'dt' => 'doctor_uuid']
    );

    $whereResult = null;
    $whereAll = null;

    $response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);

    // System-wide counts (no patient_uuid filter)
    $response['counts'] = Notes::countWhereStatus([]);

    ob_clean();
    echo json_encode($response);

} catch (Throwable $e) {
    error_log("Admin Notes DataTable Error: " . $e->getMessage());
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
