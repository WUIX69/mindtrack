<?php

include '../../../core/app.php';
apiHeaders();

use Mindtrack\Models\Users;
use Mindtrack\Utils\Php\Formatters;

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response['message'] = 'Invalid getUsers request method';
    echo json_encode($response);
    exit;
}

try {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? null;
        $user_uuid = $_GET['uuid'] ?? null;

        if ($action === 'singleWhereEdit') {

            $response = Users::single($user_uuid) ?? [];
            $user = $response['data'] ?? [];

            // Format and Fetch only needed data
            $response['data'] = [
                'uuid' => $user['uuid'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'telephone' => $user['telephone'],
                'dob' => $user['dob'],
                'role' => 'user', // TODO: Get role from user
            ];

        } else if ($action === 'singleWhereView') {
            $response = Users::single($user_uuid) ?? [];
            $response['data']['profile'] = media($response['data']['uuid']);
            $response['data']['name'] = $response['data']['firstname'] . ' ' . $response['data']['lastname'];
            $response['data']['dob'] = Formatters::dateToMDY($response['data']['dob']);
            $response['data']['created_at'] = Formatters::timeAgo($response['data']['created_at']);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;

        $data = [
            'firstname' => $_POST['firstname'] ?? '',
            'lastname' => $_POST['lastname'] ?? '',
            'email' => $_POST['email'] ?? '',
            'telephone' => $_POST['telephone'] ? $_POST['telephone'] : null,
            'dob' => $_POST['dob'] ? $_POST['dob'] : null,
            'role' => $_POST['role'] ? $_POST['role'] : null,
        ];

        if ($action === 'store') {
            $data['uuid'] = uuid();
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT); // Add password for admin manual user
            $response = Users::storeWhereUserAdmin($data) ?? [];
        } else if ($action === 'update') {
            $data['uuid'] = $_POST['uuid'] ?? null;
            $response = Users::updateWhereUserAdmin($data) ?? [];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $user_uuid = $_GET['user_uuid'] ?? null;
        $response = Users::delete($user_uuid) ?? [];
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;