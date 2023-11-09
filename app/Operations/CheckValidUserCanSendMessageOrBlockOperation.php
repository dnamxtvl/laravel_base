<?php

namespace App\Operations;

use App\Domains\User\Enums\UserExceptionEnum;
use App\Domains\User\Exceptions\UserNotFoundException;
use App\Domains\User\Jobs\CheckIsBlockedJob;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Domains\User\Jobs\FindUserJob;

class CheckValidUserCanSendMessageOrBlockOperation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $toUserId
    ) {}

    /**
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $user = (new FindUserJob(userId: $this->toUserId))->$this->handle();

        if (is_null($user)) {
            throw new UserNotFoundException(code: UserExceptionEnum::USER_NOT_FOUND_WHEN_CHECK_VALID_USER->value);
        }

        $checkIsBlocked = (new CheckIsBlockedJob(toUserId: $this->toUserId))->handle();

        if (! $checkIsBlocked) {
            throw new AccessDeniedHttpException('Bạn và họ đã block nhau từ trước!');
        }
    }
}
