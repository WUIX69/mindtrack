<?php

/**
 * Handles Create/Update operations for Patients.
 */

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Features\Patients\Server\Db\Patients;
use Mindtrack\Features\Patients\Schemas\Patients as PatientsSchema;
use Mindtrack\Lib\SessionManager;

// Check Session & Role (Admin only)
if (!$session->has() || $session->get('role') !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Handle DELETE Request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // For DELETE requests, we might need to parse the input or check $_GET depending on how it's sent
    parse_str(file_get_contents("php://input"), $_DELETE);
    $uuid = $_GET['uuid'] ?? $_DELETE['uuid'] ?? null;

    if (!$uuid) {
        echo json_encode(['success' => false, 'message' => 'UUID is required for deletion']);
        exit;
    }

    $result = Patients::delete($uuid);
    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// 1. Validate Data using Schema
$validation = PatientsSchema::validate($_POST);
if (!$validation['valid']) {
    echo json_encode([
        'success' => false,
        'message' => 'Validation failed',
        'errors' => $validation['errors']
    ]);
    exit;
}

$data = $validation['data'];
$uuid = $data['uuid'];
$isEdit = !empty($uuid);

// Ensure UUID for new patients if not provided
if (!$isEdit) {
    if (!$data['uuid']) {
        $data['uuid'] = uuid();
    }
}

// Handle Password for new patients
if (!$isEdit) {
    if (empty($_POST['password'])) {
        // Generate a random temporary password if not provided
        $tempPass = bin2hex(random_bytes(4));
        $data['password'] = password_hash($tempPass, PASSWORD_DEFAULT);
    } else {
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
}

// Perform Operation
if ($isEdit) {
    $result = Patients::update($data);
} else {
    $result = Patients::store($data);
}

echo json_encode($result);
exit;
