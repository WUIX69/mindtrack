<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Services;
use Mindtrack\Features\Services\Schemas\Services as ServicesSchema;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;

        // Validation
        $validation = ServicesSchema::validate($_POST);
        if (!$validation['valid']) {
            $response['message'] = 'Validation failed';
            $response['errors'] = $validation['errors'];
            echo json_encode($response);
            exit;
        }

        $data = $validation['data'];
        $uuid = $_POST['uuid'] ?? '';



        if ($action === 'store') {
            $data['uuid'] = uuid();
            $result = Services::store($data);
        }

        if ($action === 'update') {
            if (empty($uuid)) {
                $response['message'] = 'Service UUID is required for update';
                echo json_encode($response);
                exit;
            }
            $data['uuid'] = $uuid;
            $result = Services::update($data);
        }

        $response = array_merge($response, $result);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $uuid = $_GET['uuid'] ?? null;

        if (!$uuid) {
            parse_str(file_get_contents("php://input"), $deleteVars);
            $uuid = $deleteVars['uuid'] ?? null;
        }

        if (!$uuid) {
            $response['message'] = 'Service UUID is required for deletion';
            echo json_encode($response);
            exit;
        }

        $result = Services::delete($uuid);
        $response = array_merge($response, $result);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;