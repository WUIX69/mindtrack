<?php

require_once dirname(__DIR__, 3) . '/src/core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Categories;
use Mindtrack\Schemas\Categories as CategoriesSchema; // Import the schema

global $response;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $reference_model = $_SERVER['HTTP_X_REFERENCE_MODEL'] ?? $_GET['reference_model'] ?? null; // Support header or query param

    if (!$reference_model) {
        $response['message'] = 'Reference model is required (header: X-Reference-Model or query param)';
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;
        $validationData = $_POST;
        $validationData['reference_model'] = $reference_model;

        $validation = CategoriesSchema::validate($validationData);
        if (!$validation['valid']) {
            $response['message'] = 'Validation failed';
            $response['errors'] = $validation['errors'];
            echo json_encode($response);
            exit;
        }

        $data = $validation['data'];

        if ($action === 'store') {
            $result = Categories::store($data);
            $response = array_merge($response, $result);
        }

        if ($action === 'update') {
            if (empty($data['id'])) {
                $response['message'] = 'Category ID is required for update';
                echo json_encode($response);
                exit;
            }
            $result = Categories::update($data);
            $response = array_merge($response, $result);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? 'all';

        if ($action === 'all') {
            $result = Categories::all($reference_model);
            $response = array_merge($response, $result);
        }

        if ($action === 'single') {
            $category_id = $_GET['id'] ?? null;
            if (!$category_id) {
                $response['message'] = 'Category ID is required';
                echo json_encode($response);
                exit;
            }
            $result = Categories::single($category_id, $reference_model);
            $response = array_merge($response, $result);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $category_id = $_GET['id'] ?? null;
        if (!$category_id) {
            $response['message'] = 'Category ID is required for deletion';
            echo json_encode($response);
            exit;
        }
        $result = Categories::delete($category_id, $reference_model);
        $response = array_merge($response, $result);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;