<?php

/**
 * Validates and processes the DataTables request for Admin Users.
 */

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;

// Get DB Connection
$conn = Base::conn();

/**
 * Build the base query.
 * Admins only exist in the users table, no secondary info tables.
 */
$format_table = "
    SELECT 
        uuid,
        firstname,
        lastname,
        email,
        phone,
        status,
        role,
        is_email_verified,
        created_at,
        updated_at
    FROM users
    WHERE role = 'admin'
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
    ['db' => 'role', 'dt' => 'role'],
    ['db' => 'is_email_verified', 'dt' => 'is_email_verified'],
    ['db' => 'created_at', 'dt' => 'created_at'],
    ['db' => 'updated_at', 'dt' => 'updated_at'],
    ['db' => 'uuid', 'dt' => 'uuid'], // For actions
    ['db' => null, 'dt' => 'actions'], // Placeholder for client-side actions
);

// Apply Filters (Native DataTables handling)
$whereResult = null;
$whereAll = null;

// Get Data
$response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);

echo json_encode($response);
exit;
