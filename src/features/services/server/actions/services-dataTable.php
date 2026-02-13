<?php

/**
 * Validates and processes the cleanup of the DataTables request for Services.
 */

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;
use Mindtrack\Server\Db\Services;

// Get DB Connection
$conn = Base::conn();

/**
 * Build the base query.
 * We use a subquery approach to join categories and specializations.
 */
$format_table = "
    SELECT 
        s.uuid,
        s.name,
        c.name AS category_name,
        sp.name AS specialization_name,
        s.price,
        s.duration,
        s.status,
        s.description,
        s.created_at,
        s.updated_at
    FROM services s
    LEFT JOIN categories c ON s.category_id = c.id
    LEFT JOIN specializations sp ON s.specialization_id = sp.id
";

// Use the subquery as the table source
$table = "($format_table) as derived_table";
$primaryKey = 'uuid';

// Define column mappings
$columns = array(
    ['db' => 'name', 'dt' => 'name'],
    ['db' => 'category_name', 'dt' => 'category_name'],
    ['db' => 'specialization_name', 'dt' => 'specialization_name'],
    ['db' => 'price', 'dt' => 'price'],
    ['db' => 'duration', 'dt' => 'duration'],
    ['db' => 'created_at', 'dt' => 'created_at'],
    ['db' => 'updated_at', 'dt' => 'updated_at'],
    ['db' => 'status', 'dt' => 'status'],
    ['db' => 'uuid', 'dt' => 'uuid'], // For actions
    ['db' => null, 'dt' => 'actions'], // Placeholder for client-side actions
);

// Apply Filters
$whereResult = null;
$whereAll = null;

// Category Filter handling removed - utilizing DataTables column search instead

// Get Data
$response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);

// Get Counts for Stats
$response['counts'] = Services::countWhereStatuses();

echo json_encode($response);
exit;
