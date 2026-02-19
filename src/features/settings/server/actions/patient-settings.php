<?php

include '../../../../core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
use Mindtrack\Features\Settings\Schemas\Settings;

global $response;

$user_uuid = userData()['uuid'] ?? null;
if (!$user_uuid) {

    $response['message'] = 'User not authenticated.';
    echo json_encode($response);
    exit;
}

// Handle GET Request (Fetch Settings)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $result = Users::singleWherePatient($user_uuid);
        // Merge result into response
        if (is_array($result)) {
            $response = array_merge($response, $result);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());

        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
}

// Handle POST Request (Update Settings)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate Data
        $validation = Settings::validate($_POST);

        if (!$validation['valid']) {
            // Format validation errors for response
            // Respect Validation returns nested array of messages or single string depending on method
            // Here we assume getMessages() returns array [field => [messages]] or [messages]
            $errors = $validation['errors'];
            $message = 'Validation failed';

            // Extract first error message if available
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


            $response['message'] = $message;
            $response['errors'] = $errors;
            echo json_encode($response);
            exit;
        }

        $validData = $validation['data'];
        $data = array_merge($validData, ['uuid' => $user_uuid]);

        // Call Model Update
        $result = Users::updateWherePatient($data);

        if (!$result['success']) {
            throw new Exception($result['message'] ?? 'Failed to update settings');
        }

        $response['success'] = true;
        $response['message'] = 'Settings updated successfully';

    } catch (Exception $e) {
        error_log("Patient Settings Update Error: " . $e->getMessage());

        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
}

// Invalid Method

$response['message'] = 'Invalid request method';
echo json_encode($response);
exit;
