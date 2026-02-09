<?php

require_once dirname(__DIR__, 2) . '/core/app.php';
apiHeaders();

if (isset($session)) {
    $session->destroy();
}

$response = array_merge($response, [
    'success' => true,
    'message' => 'Logged out successfully',
    'data' => [
        'route' => app('auth')
    ]
]);

echo json_encode($response);
exit;
