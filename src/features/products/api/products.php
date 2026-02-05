<?php

include '../../../core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Products;
use Mindtrack\Server\Db\Categories;
use Mindtrack\Server\Db\Attachments;

use Mindtrack\Utils\Helpers;
use Mindtrack\Utils\Formatters;

use Mindtrack\Lib\FileManager;
use Mindtrack\Lib\Media;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $fileManager = new FileManager();
    $reference_model = 'products';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;

        $data = [
            'category_id' => $_POST['category_id'] ?? '',
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'og_price' => $_POST['og_price'] ?? '',
            'dc_price' => $_POST['dc_price'] ? $_POST['dc_price'] : null,
            'stock' => $_POST['stock'] ?? '',
            'status' => $_POST['status'] ?? '',
            'tags' => $_POST['tags'] ? $_POST['tags'] : null,
            'specs' => $_POST['specs'] ? $_POST['specs'] : null,
            'files' => $_POST['files'] ? explode(',', $_POST['files']) : [],
        ];

        if ($action === 'store') {

            $data['uuid'] = uuid();
            $response = Products::store($data);
            foreach ($data['files'] as $file) {
                $fileManager->storeWherePermanent($file, $reference_model, $data['uuid']);
            }

        } else if ($action === 'update') {

            $data['uuid'] = $_POST['uuid'] ?? null; // add product uuid to data, required for update
            $response = Products::update($data);
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

            $products = Products::all();
            $products['data'] = array_map(function ($item) use ($reference_model) {
                // Format correct data
                $formattedData = [
                    'image' => Media::get($item['uuid']),
                    'category' => Helpers::categoryName(Categories::single($item['category_id'], $reference_model)['data']),
                    'status' => Helpers::productStatus($item['status']),
                    'tags' => $item['tags'] ? count(explode(',', $item['tags'])) : 0,
                    'specs' => $item['specs'] ? count(explode(',', $item['specs'])) : 0,
                    'created_at' => Formatters::dateToMDY($item['created_at']),
                    'updated_at' => Formatters::dateToMDY($item['updated_at']),
                ];

                // Remove unnecessary data
                unset($item['category_id'], $item['dc_price'], $item['features'], $item['size']);

                // Merge formatted data with the original item
                return array_merge($item, $formattedData);
            }, $products['data'] ?? []);
            $response = $products;

        } else if ($action === 'single') {
            $product_uuid = $_GET['uuid'] ?? null;
            $response = Products::single($product_uuid);
            $response['data']['files'] = Attachments::all($product_uuid)['data'] ?? []; // Get product files
        } else {
            $response['message'] = 'Invalid GET action';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $product_uuid = $_GET['uuid'] ?? null;
        $response = Products::delete($product_uuid);
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