<?php

use Mindtrack\Server\Db\Users;
use Ramsey\Uuid\Uuid;
use Mindtrack\Lib\Media;

function uuid()
{
    $my_uuid = Uuid::uuid4();
    return $my_uuid->toString();
}

function userData($uuid = null)
{
    global $session;
    if (!$uuid) {
        $uuid = $session->get('uuid');
    }

    $user = Users::single($uuid)['data'] ?? [];
    $user_formatted_data = [
        'role' => $session->get('role') ?? $session->get('type') ?? '',
        'name' => ($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''),
        'profile' => Media::get($uuid) ?? null,
    ];

    $merged_data = array_merge($user, $user_formatted_data);
    return $merged_data;
}