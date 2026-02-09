<?php

use Mindtrack\Server\Db\Users;
use Mindtrack\Lib\Media;
use Ramsey\Uuid\Uuid;

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
    $user_other_data = Users::singleWhereOtherData($uuid, $session->get('role')) ?? [];
    $user_formatted_data = [
        'role' => $session->get('role') ?? $session->get('type') ?? '',
        'name' => ($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''),
        'profile' => Media::get($uuid) ?? null,
    ];

    $merged_data = array_diff_key(
        array_merge($user, $user_other_data, $user_formatted_data),
        ['user_uuid' => true]
    );

    // error_log(json_encode($merged_data));
    return $merged_data;
}