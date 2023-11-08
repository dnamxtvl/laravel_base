<?php

namespace App\Domains\User\Enums;

enum UserExceptionEnum: int
{
    case SEND_MESSAGE_VALIDATION_ERROR = 8445628;

    case USER_NOT_FOUND_WHEN_CHECK_VALID_USER = 242342;

    case USER_NOT_FOUND_WHEN_UNBLOCK = 242332;
}
