<?php

namespace Mindtrack\Utils;

use Ramsey\Uuid\Uuid;

function uuid()
{
    $my_uuid = Uuid::uuid4();
    return $my_uuid->toString();
}