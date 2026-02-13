<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Services;

global $response; // Call from app.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;

        $data = [
            'category_id' => $_POST['category_id'] ?? '',
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'price' => $_POST['price'] ? $_POST['price'] : null,
            'status' => $_POST['status'] ?? '',
            'duration' => $_POST['duration'] ? $_POST['duration'] : null,
        ];

        if ($action === 'store') {
            $data['uuid'] = uuid();
            $response = Services::store($data);
        } else if ($action === 'update') {
            $data['uuid'] = $_POST['uuid'] ?? null; // add service uuid to data, required for update
            $response = Services::update($data);
        } else {
            $response['message'] = 'Invalid POST action';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $product_uuid = $_GET['uuid'] ?? null;
        $response = Services::delete($product_uuid);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;