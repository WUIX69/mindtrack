<?php
require_once dirname(__DIR__, 5) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Features\Doctors\Schemas\Doctors;
use Mindtrack\Server\Db\Specialization;
use Mindtrack\Server\Db\Users;

global $response; // already handles default (status, message, data)

// GET Request - Fetch Single Doctor
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uuid = $_GET['uuid'] ?? null;

    if (!$uuid) {
        $response['message'] = 'UUID required';
        echo json_encode($response);
        exit;
    }

    $result = Users::singleWhereDoctor($uuid);
    $response = array_merge($response, $result);
}

// POST Request - Create or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CREATE or UPDATE Logic

    // 1. Validate Data
    $validation = Doctors::validate($_POST);
    if (!$validation['valid']) {
        $response['message'] = 'Validation failed';
        $response['errors'] = $validation['errors'];
        echo json_encode($response);
        exit;
    }

    $data = $validation['data'];
    $uuid = $_POST['uuid'] ?? ''; // From form hidden input

    // 2. Handle Specialization
    $specId = 8; // Default
    if (!empty($data['specialty'])) {
        $spec = Specialization::findByName($data['specialty']);
        if ($spec) {
            $specId = $spec['id'];
        } else {
            $specId = Specialization::create($data['specialty']);
        }
    }

    $data['specialization_id'] = $specId;

    // 3. Process based on UUID presence (Update vs Create)
    if (!empty($uuid)) {
        // --- UPDATE ---
        $data['uuid'] = $uuid;

        // Password: only update if provided
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $result = Users::updateWhereDoctor($data);

    } else {
        // --- CREATE ---
        // Password required
        if (empty($_POST['password'])) {
            $response['message'] = 'Password is required for new accounts.';
            echo json_encode($response);
            exit;
        }

        $data['uuid'] = uuid();
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $result = Users::storeWhereDoctor($data);
        if ($result['success']) {
            $response['data'] = ['uuid' => $data['uuid']];
        }
    }

    $response = array_merge($response, $result);
}

// DELETE Request - Delete Doctor
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse input stream for DELETE data
    parse_str(file_get_contents("php://input"), $deleteVars);
    $uuid = $deleteVars['uuid'] ?? $_GET['uuid'] ?? null; // Support body or query param

    if (!$uuid) {
        $response['message'] = 'UUID required for deletion';
        echo json_encode($response);
        exit;
    }

    $result = Users::delete($uuid);
    $response = array_merge($response, $result);
}

echo json_encode($response);
exit;
