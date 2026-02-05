<?php

include '../../../core/app.php';
apiHeaders();

use Mindtrack\Models\Users;
use Mindtrack\Models\Attachments;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['message'] = 'Invalid request GET method';
    echo json_encode($response);
    exit;
}

try {

    $user_uuid = userData()['uuid'];
    $response = Users::single($user_uuid) ?? [];
    $user = $response['data'] ?? [];

    // Format and Fetch only needed data
    $response['data'] = [
        'firstname' => $user['firstname'],
        'lastname' => $user['lastname'],
        'email' => $user['email'],
        'bio' => $user['bio'],
        'telephone' => $user['telephone'],
        'dob' => $user['dob'],
        'location' => $user['location'],
        'urls' => $user['urls'] ? explode(',', $user['urls']) : [], // Format the urls array
        'profile' => Attachments::single($user_uuid)['data'],
    ];

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;