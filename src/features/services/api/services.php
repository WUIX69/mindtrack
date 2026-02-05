<?php

include '../../../core/app.php';
apiHeaders();

use VetSync\Models\Services;
use VetSync\Models\Categories;
use VetSync\Models\Attachments;

use VetSync\Utils\Php\Helpers;
use VetSync\Utils\Php\Formatters;

use VetSync\Services\FileManager;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $fileManager = new FileManager();
    $reference_model = 'services';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;

        $data = [
            'category_id' => $_POST['category_id'] ?? '',
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'price' => $_POST['price'] ? $_POST['price'] : null,
            'status' => $_POST['status'] ?? '',
            'duration' => $_POST['duration'] ? $_POST['duration'] : null,
            // 'faqs' => $_POST['faqs'] ? $_POST['faqs'] : null,
            'files' => $_POST['files'] ? explode(',', $_POST['files']) : [],
        ];

        if ($action === 'store') {

            $data['uuid'] = uuid();
            $response = Services::store($data);
            foreach ($data['files'] as $file) {
                $fileManager->storeWherePermanent($file, $reference_model, $data['uuid']);
            }
        } else if ($action === 'update') {
            $data['uuid'] = $_POST['uuid'] ?? null; // add service uuid to data, required for update
            $response = Services::update($data);
            foreach ($data['files'] as $file) {
                $fileManager->storeWherePermanent($file, $reference_model, $data['uuid']);
            }
        } else {
            $response['message'] = 'Invalid POST action';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? null;

        if ($action === 'all') {

            $result = Services::all();
            $result['data'] = array_map(function ($item) use ($reference_model) {
                // Format correct data
                $formattedData = [
                    'image' => media($item['uuid']),
                    'category' => Helpers::categoryName(Categories::single($item['category_id'], $reference_model)['data']),
                    'status' => Helpers::serviceStatus($item['status']),
                    'created_at' => Formatters::dateToMDY($item['created_at']),
                    'updated_at' => Formatters::dateToMDY($item['updated_at']),
                ];

                // Remove unnecessary data
                unset($item['category_id'], $item['faqs'], $item['etd']);

                // Merge formatted data with the original item
                return array_merge($item, $formattedData);
            }, $result['data'] ?? []);
            $response = $result;

        } else if ($action === 'single') {
            $product_uuid = $_GET['uuid'] ?? null;
            $response = Services::single($product_uuid);
            $response['data']['files'] = Attachments::all($product_uuid)['data'] ?? []; // Get product files
        } else {
            $response['message'] = 'Invalid GET action';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $product_uuid = $_GET['uuid'] ?? null;
        $response = Services::delete($product_uuid);
        if ($response['success']) {
            $fileManager->deleteWhereReferencePermanent($product_uuid, $reference_model);
        }
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;