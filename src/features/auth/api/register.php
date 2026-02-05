<?php

include '../../../core/app.php';
apiHeaders();

use Mindtrack\Models\Users;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $data = [
        'uuid' => uuid(),
        'firstname' => $_POST['firstname'] ?? '',
        'lastname' => $_POST['lastname'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '',
    ];

    $user = Users::store($data);
    $response = array_merge($response, $user);

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;