<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
use Mindtrack\Features\Settings\Schemas\DoctorSettings;

global $response;

// Guard: Authentication
$doctor_uuid = $session->get('uuid') ?? userData()['uuid'] ?? null;
if (!$doctor_uuid) {
    $response['message'] = 'Doctor not authenticated.';
    echo json_encode($response);
    exit;
}

// Guard: Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Handle GET Request (Fetch Settings)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = Users::singleWhereDoctor($doctor_uuid);
    $response = array_merge($response, $result);
    echo json_encode($response);
    exit;
}

// Handle POST Request (Update Settings)
$validation = DoctorSettings::validate($_POST);

// Guard: Validation
if (!$validation['valid']) {
    $errors = $validation['errors'];

    // Extract first error message
    $message = 'Validation failed';
    if (is_array($errors)) {
        $firstError = reset($errors);
        $message = is_array($firstError) ? reset($firstError) : $firstError;
    } elseif (is_string($errors)) {
        $message = $errors;
    }

    $response['message'] = $message;
    $response['errors'] = $errors;
    echo json_encode($response);
    exit;
}

// Process Update
$data = array_merge($validation['data'], ['uuid' => $doctor_uuid]);
$result = Users::updateWhereDoctor($data);
$response = array_merge($response, $result);

echo json_encode($response);
exit;
