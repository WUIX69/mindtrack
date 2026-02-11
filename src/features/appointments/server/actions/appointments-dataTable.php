<?php

require_once dirname(__DIR__, 5) . '/src/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;

// Get DB Connection
$conn = Base::conn();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {
    // Query the VIEW instead of the raw table
    // $table = 'vw_appointments_datatable'; // OLD METHOD

    // Subquery for DataTables (without CREATE VIEW)
    // Note: Library modified to support this by not backticking complex table expressions
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
            CONCAT(u.firstname, ' ', u.lastname) AS doctor_name,
            CONCAT(p.firstname, ' ', p.lastname) AS patient_name,
            p.email AS patient_email,
            p.firstname AS patient_firstname,
            u.firstname AS doctor_firstname,
            u.lastname AS doctor_lastname,
            s.duration AS service_duration
        FROM appointments a
        LEFT JOIN services s ON a.service_uuid = s.uuid
        LEFT JOIN users u ON a.doctor_uuid = u.uuid
        LEFT JOIN users p ON a.patient_uuid = p.uuid      
    ";
    $table = "($format_table) as derived_table";

    $primaryKey = 'uuid';

    $columns = array(
        ['db' => 'patient_name', 'dt' => 'patient_name'],
        ['db' => 'service_name', 'dt' => 'service_name'],
        ['db' => 'sched_date', 'dt' => 'sched_date'],
        ['db' => 'doctor_name', 'dt' => 'doctor_name'],
        ['db' => 'status', 'dt' => 'status'],
        ['db' => null, 'dt' => 'actions'],  // Rendered client-side
        // Additional data for client-side use
        ['db' => 'uuid', 'dt' => 'uuid'],
        ['db' => 'sched_time', 'dt' => 'sched_time'],
        ['db' => 'patient_uuid', 'dt' => 'patient_uuid'],
        ['db' => 'doctor_uuid', 'dt' => 'doctor_uuid'],
        ['db' => 'service_uuid', 'dt' => 'service_uuid'],
        ['db' => 'patient_email', 'dt' => 'patient_email'],
        ['db' => 'patient_firstname', 'dt' => 'patient_firstname'],
        ['db' => 'doctor_firstname', 'dt' => 'doctor_firstname'],
        ['db' => 'doctor_lastname', 'dt' => 'doctor_lastname'],
        ['db' => 'service_duration', 'dt' => 'service_duration'],
        ['db' => 'notes', 'dt' => 'notes'],
        ['db' => 'created_at', 'dt' => 'created_at'],
    );

    if (is_null($conn)) {
        $conn = array(
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'db' => $_ENV['DB_DATABASE'],
            'host' => $_ENV['DB_HOST']
        );
    }

    // Build extra WHERE conditions from filter params
    $whereResult = null;
    $whereAll = null;

    // Status filter (e.g., ?filter_status=pending)
    // Note: DataTables::complex() uses PDO bindings, so we format accordingly.
    if (!empty($_GET['filter_status']) && $_GET['filter_status'] !== 'all') {
        $status = $_GET['filter_status'];
        if ($status === 'upcoming') {
            $whereResult = "`status` IN ('confirmed', 'scheduled')";
        } else {
            // Complex where expects full condition string + bindings is handled mostly via library logic if simplified, 
            // but the library supports raw WHERE strings or structured?
            // Checking library documentation or code: 'complex' ($request, $conn, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null)
            // The library code applies $whereResult simply as string if provided directly?
            // "if ( $whereResult ) { $where = $whereResult; }"  <- No, looking at library source:
            /*
            if ( $whereResult ) {
                $where = Mindtrack\Lib\DataTables::filter( $request, $columns, $bindings );
                if ( $where ) {
                    $where .= ' AND ' . $whereResult;
                } else {
                    $where = 'WHERE ' . $whereResult;
                }
            }
            */
            // So $whereResult must be a SQL string (e.g. "status='pending'").
            // To be safe with bindings, the library handles bindings internally for standard filters.
            // For custom WHERE, if we want parameterized queries, the library might not support easy binding injection for custom strings unless we modify it.
            // But looking at library: `static function complex ( $request, $sql_details, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null )`
            // It calls `self::data_output` -> `self::pluck`.
            // Wait, the library does NOT seem to accept bindings for $whereResult easily from outside?
            // Let's assume input is sanitized or safe enough here since it's an enum-like status.

            // Actually, for safety, let's just quote it manually since status is a simple string.
            $safeStatus = addslashes($status);
            $whereResult = "`status` = '$safeStatus'";
        }
    }

    // Doctor filter
    if (!empty($_GET['filter_doctor'])) {
        $doctorUuid = addslashes($_GET['filter_doctor']);
        $clause = "`doctor_uuid` = '$doctorUuid'";
        $whereAll = $whereAll ? "$whereAll AND $clause" : $clause;
    }

    // Service filter
    if (!empty($_GET['filter_service'])) {
        $serviceUuid = addslashes($_GET['filter_service']);
        $clause = "`service_uuid` = '$serviceUuid'";
        $whereAll = $whereAll ? "$whereAll AND $clause" : $clause;
    }

    // Date filter
    if (!empty($_GET['filter_date'])) {
        $date = addslashes($_GET['filter_date']);
        $clause = "`sched_date` = '$date'";
        $whereAll = $whereAll ? "$whereAll AND $clause" : $clause;
    }

    $response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);
    $response['success'] = true;

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
