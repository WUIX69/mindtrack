<?php

/**
 * Validates and processes the cleanup of the DataTables request for Categories.
 */

require_once dirname(__DIR__, 2) . '/core/app.php';

use Mindtrack\Server\Db\Base;
use Mindtrack\Lib\DataTables;

// Get DB Connection
$conn = Base::conn();

$table = 'categories';
$primaryKey = 'id';

// Define column mappings
$columns = array(
    ['db' => 'icon', 'dt' => 'icon'],
    ['db' => 'name', 'dt' => 'name'],
    ['db' => 'description', 'dt' => 'description'],
    ['db' => 'status', 'dt' => 'status'],
    ['db' => 'id', 'dt' => 'id'], // For actions
    ['db' => null, 'dt' => 'actions'], // Placeholder for client-side actions
    ['db' => 'created_at', 'dt' => 'created_at'],
    ['db' => 'updated_at', 'dt' => 'updated_at']
);

// Apply Filters
$whereResult = null;
$whereAll = null;

// Reference Model Filter (Critical)
$reference_model = $_GET['reference_model'] ?? null;
if ($reference_model) {
    $ref = addslashes($reference_model);
    $whereAll = "reference_model = '$ref'";
}

// Search filter handled by DataTables::simple internally for basic columns, 
// but we pass whereAll to restrict to the reference_model.

// Get Data
$response = DataTables::complex($_GET, $conn, $table, $primaryKey, $columns, $whereResult, $whereAll);
// Note: Using complex() here instead of simple() because simple() doesn't support $whereAll/$whereResult in standard implementations often, 
// but if the library supports it, great. The user requested simple(), but complex() covers it safely with the WHERE clause.
// Let's stick to complex to ensure the reference_model constraint is applied correctly via $whereAll.
// Re-reading user request: "you can use simple()". If simple() accepts a WHERE clause in this codebase's lib, I'd use it.
// Safest bet is complex() with the where clause to guarantee isolation. 

echo json_encode($response);
exit;
