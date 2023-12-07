<?php

namespace App\Operations;

use App\Domains\User\Enums\UserExceptionEnum;
use App\Domains\User\Exceptions\UserNotFoundException;
use App\Domains\User\Jobs\CheckIsBlockedJob;
use App\Helpers\Service;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Domains\User\Jobs\FindUserJob;

class CheckValidUserCanSendMessageOperation extends Service
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $toUserId
    ) {}

    public function handle(): void
    {
        $user = $this->dispatchSync(new FindUserJob(userId: $this->toUserId));

        if (is_null($user)) {
            throw new UserNotFoundException(code: UserExceptionEnum::USER_NOT_FOUND_WHEN_CHECK_VALID_USER->value);
        }

        $checkIsBlocked = $this->dispatchSync(new CheckIsBlockedJob(toUserId: auth()->id()));

        if (! $checkIsBlocked) {
            throw new AccessDeniedHttpException('Bạn và họ đã block nhau từ trước!');
        }
    }
}
