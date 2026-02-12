<?php
require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Server\Db\Specialization;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$status = $_POST['status'] ?? 'active';

if (empty($action)) {
    $response['message'] = 'Action is required.';
    echo json_encode($response);
    exit;
}

switch ($action) {
    case 'create':
        if (empty($name)) {
            $response['message'] = 'Name is required.';
            echo json_encode($response);
            exit;
        }
        $result = Specialization::store([
            'name' => $name,
            'description' => $description,
            'status' => $status
        ]);
        break;

    case 'update':
        if (empty($id)) {
            $response['message'] = 'ID is required to update.';
            echo json_encode($response);
            exit;
        }
        if (empty($name)) {
            $response['message'] = 'Name is required.';
            echo json_encode($response);
            exit;
        }
        $result = Specialization::update($id, [
            'name' => $name,
            'description' => $description,
            'status' => $status
        ]);
        break;

    case 'delete':
        if (empty($id)) {
            $response['message'] = 'ID is required to delete.';
            echo json_encode($response);
            exit;
        }
        $result = Specialization::delete($id);
        break;

    default:
        $response['message'] = 'Invalid action.';
        echo json_encode($response);
        exit;
}

$response = array_merge($response, $result);
echo json_encode($response);
exit;
