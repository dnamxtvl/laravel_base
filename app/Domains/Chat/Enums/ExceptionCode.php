<?php

namespace App\Domains\Chat\Enums;

enum ExceptionCode: int
{
    case SEND_MESSAGE_VALIDATION_ERROR = 85628;

    case SEND_MESSAGE_FAIL = 24242;

    case BLOCK_USER_FAIL = 252552;
}
