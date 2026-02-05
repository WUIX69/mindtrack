<?php

include '../../core/app.php';
apiHeaders();

use VetSync\Models\Categories;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $reference_model = $_SERVER['HTTP_X_REFERENCE_MODEL'] ?? null; // (e.g. products, services) only
    error_log("reference_model: " . $reference_model);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;
        $data = [
            'reference_model' => $reference_model,
            'icon' => $_POST['icon'] ? $_POST['icon'] : null,
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ? $_POST['description'] : null,
            'status' => $_POST['status'] ?? '',
        ];

        if ($action === 'store') {
            $response = Categories::store($data);
        } else if ($action === 'update') {
            $data['id'] = $_POST['id'] ?? null; // add id to data, required for update
            $response = Categories::update($data);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? null;

        if ($action === 'all') {
            $response = Categories::all($reference_model);
        } else if ($action === 'single') {
            $category_id = $_GET['id'] ?? null;
            $response = Categories::single($category_id, $reference_model);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $category_id = $_GET['id'] ?? null;
        error_log("category_id: " . $category_id);
        error_log("reference_model on delete: " . $reference_model);
        $response = Categories::delete($category_id, $reference_model);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;