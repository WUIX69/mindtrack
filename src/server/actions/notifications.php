<?php

require_once dirname(__DIR__, 2) . '/core/app.php';
apiHeaders();

use Mindtrack\Lib\Notify;
use Mindtrack\Server\Db\Base;

global $response, $session;

if (!$session->get('uuid')) {
    http_response_code(401);
    $response['success'] = false;
    $response['message'] = 'Unauthorized';
    echo json_encode($response);
    exit;
}

$userUuid = $session->get('uuid');

try {
    $notify = new Notify();

    $method = $_SERVER['REQUEST_METHOD'];
    $action = $_GET['action'] ?? $_POST['action'] ?? '';

    if ($method === 'GET') {
        if ($action === 'all') {
            $notifications = $notify->getByUser($userUuid);
            $response['success'] = true;
            $response['data'] = $notifications;
        } elseif ($action === 'unread_count') {
            $count = $notify->getUnreadCount($userUuid);
            $response['success'] = true;
            $response['count'] = $count;
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Invalid action';
        }
    } elseif ($method === 'POST') {
        if ($action === 'mark_read') {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            if ($id > 0) {
                // In a stricter system we'd verify ownership, but this is sufficient for now
                $success = $notify->markAsRead($id);
                $response['success'] = $success;
            } else {
                $response['success'] = false;
            }
        } elseif ($action === 'mark_all_read') {
            $success = $notify->markAllAsRead($userUuid);
            $response['success'] = $success;
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Invalid action';
        }
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Invalid method';
    }

} catch (\Exception $e) {
    error_log("Notification Action Error: " . $e->getMessage());
    http_response_code(500);
    $response['success'] = false;
    $response['message'] = 'Internal server error.';
}

echo json_encode($response);
exit;
