<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Features\Settings\Schemas\Deactivation as DeactivationSchema;
use Mindtrack\Features\Settings\Server\Db\Deactivation as DeactivationDb;

$user_uuid = $session->get('uuid') ?? userData()['uuid'] ?? null;
if (!$user_uuid) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate payload
        $validation = DeactivationSchema::validate($_POST);

        if (!$validation['valid']) {
            $errors = $validation['errors'];
            $message = 'Validation failed.';

            if (is_array($errors)) {
                $firstError = reset($errors);
                if (is_array($firstError)) {
                    $message = reset($firstError);
                } else {
                    $message = $firstError;
                }
            } elseif (is_string($errors)) {
                $message = $errors;
            }

            echo json_encode(['success' => false, 'message' => $message, 'errors' => $errors]);
            exit;
        }

        $validData = $validation['data'];

        // 1. Log the reason
        $logResult = DeactivationDb::storeLog($user_uuid, $validData['reason'], $validData['feedback']);
        if (!$logResult['success']) {
            throw new \Exception('Failed to log deactivation reason.');
        }

        // 2. Soft-delete user
        $deactivateResult = DeactivationDb::deactivateUser($user_uuid);
        if (!$deactivateResult['success']) {
            throw new \Exception('Failed to deactivate user profile.');
        }

        // 3. Destroy session to log out User immediately
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        echo json_encode([
            'success' => true,
            'message' => 'Account successfully deactivated. You will now be redirected...'
        ]);
        exit;

    } catch (\Exception $e) {
        error_log("Deactivation Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
exit;
