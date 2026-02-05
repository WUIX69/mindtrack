<?php

use Mindtrack\Server\Db\Users;

function userData($uuid = null)
{
    global $session;
    if (!$uuid) {
        $uuid = $session->get()['uuid'] ?? null;
    }

    $user = Users::single($uuid);
    $user_formatted_data = [
        'type' => $session->get()['type'] ?? '',
        'name' => $user['firstname'] . ' ' . $user['lastname'] ?? '',
        'profile' => media($uuid) ?? null,
    ];

    $merged_data = array_merge($user, $user_formatted_data);
    return $merged_data;
}