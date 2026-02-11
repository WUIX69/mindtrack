<?php
require_once dirname(__DIR__, 2) . '/core/app.php';

use Mindtrack\Server\Db\Specialization;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

$specializations = Specialization::all();
$response = array_merge($response, $specializations);

echo json_encode($response);
exit;
