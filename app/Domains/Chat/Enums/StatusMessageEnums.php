<?php

namespace App\Domains\Chat\Enums;

enum StatusMessageEnums: int
{
    case STATUS_UNREAD = 0;
    case STATUS_READ = 1;
    case STATUS_REVOKE = 2;
}
