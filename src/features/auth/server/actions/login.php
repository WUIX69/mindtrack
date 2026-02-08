<?php

include '../../../core/app.php';
apiHeaders();

use Mindtrack\Server\Db\Users;
// global $response;
// global $session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

try {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = Users::singleWhereUserEmail($email);
    $admin = Users::singleWhereAdminEmail($email);

    if ($user && password_verify($password, $user['password'])) {

        $session->set($user);
        $session->add(['type' => 'user']);

        $response = array_merge($response, [
            'success' => true,
            'message' => 'Welcome user',
            'data' => [
                'route' => app('user'),
            ],
        ]);

    } else if ($admin && password_verify($password, $admin['password'])) {

        $session->set($admin);
        $session->add(['type' => 'admin']);

        $response = array_merge($response, [
            'success' => true,
            'message' => 'Welcome admin',
            'data' => [
                'route' => app('admin'),
            ],
        ]);

    } else {
        $response['message'] = 'Invalid email and/or password!';
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
