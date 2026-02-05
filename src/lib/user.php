<?php

use Ramsey\Uuid\Uuid;

function uuid()
{
    $my_uuid = Uuid::uuid4();
    return $my_uuid->toString();
}

function getUserByUuid($uuid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE uuid = ? LIMIT 1");
    $stmt->execute([$uuid]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAdminById($id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM administrators WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function userData($uuid = null)
{
    global $session;
    if (!$uuid) {
        $uuid = $session->get()['uuid'] ?? null;
    }

    $user = getUserByUuid($uuid);
    $user_formatted_data = [
        'type' => $session->get()['type'] ?? '',
        'name' => $user['firstname'] . ' ' . $user['lastname'] ?? '',
        'profile' => media($uuid) ?? null,
    ];

    $merged_data = array_merge($user, $user_formatted_data);
    return $merged_data;
}