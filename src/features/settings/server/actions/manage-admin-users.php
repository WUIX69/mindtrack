<?php

/**
 * Handles Create/Update operations for Admin Users.
 */

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Server\Db\Users;
use Mindtrack\Features\Settings\Schemas\AdminUsers as AdminUsersSchema;

// Check Session & Role (Admin only)
if (!$session->has() || $session->get('role') !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Handle DELETE Request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $uuid = $_GET['uuid'] ?? $_DELETE['uuid'] ?? null;

    if (!$uuid) {
        echo json_encode(['success' => false, 'message' => 'UUID is required for deletion']);
        exit;
    }

    $result = Users::delete($uuid);
    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// 1. Validate Data using Schema
$validation = AdminUsersSchema::validate($_POST);
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

if (!$isEdit) {
    // Creating a new admin
    $data['uuid'] = uuid();
    $data['role'] = 'admin';
    $data['status'] = $data['status'] ?? 'active';
    $data['email_verification_token'] = uuid();

    if (empty($data['password'])) {
        echo json_encode(['success' => false, 'message' => 'Password is required for new accounts.']);
        exit;
    }
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    // Use the generic store method
    $result = Users::store($data);

    if ($result['success']) {
        \Mindtrack\Lib\Email::sendVerificationEmail($data['email'], $data['firstname'], $data['lastname'], $data['email_verification_token']);
    }
} else {
    // Updating existing admin
    // In Users::update, it might expect specific fields, so we need to add a specialized method or direct query 
    // since the user wants to use `Users` class. We will add `Users::updateWhereAdmin()` to `users.php`.
    if (!empty($data['password'])) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    } else {
        unset($data['password']); // Don't update if empty
    }

    $result = Users::updateWhereAdmin($data);
}

echo json_encode($result);
exit;
